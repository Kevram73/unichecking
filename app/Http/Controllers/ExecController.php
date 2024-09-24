<?php

namespace App\Http\Controllers;

use App\Models\Deplacement;
use App\Models\Enseignant;
use App\Models\Logs;
use App\Models\Scan;
use App\Models\Scanner;
use App\Models\ScanPresence;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MachineLog;
use Illuminate\Support\Facades\DB;

class ExecController extends Controller
{
    private $types;

    public function __construct()
    {
        // Initialisation des types de commandes
        $this->types = [
            0 => "MAKE_DEFAULT",
            1 => "GET_DEVICE_INFO",
            2 => "GET_USER_ID_LIST",
            3 => "GET_LOG_DATA",
            4 => "CLEAR_LOG_DATA",
            5 => "RESET_FK",
            6 => "ENTER_ENROLL",
        ];


    }

    public function index(Request $request){
        $headers_data = getallheaders();
        $body_data = $request->all();
        $device = $this->univ_for_device($headers_data["dev_id"]);
        $log = new Logs();
        $log->contenu = json_encode($request->all());
        $log->type = json_encode($headers_data);
        $log->dev_id = $request->time;
        $log->save();

        if($request->time){

            $scan = new Scan();
            $scan->time = $request->time;
            $scan->user_id = $request->userId;
            $scan->log_photo = $request->logPhoto;
            $scan->save();

            $ens = $this->find_ens($body_data['userId']);
            $date = Carbon::createFromFormat('YmdHis', $body_data['time']);
            $day = $date->dayOfWeekIso;
            $scanp = new ScanPresence();
//            $scanp->universite_id = $device->universite_id;
//            $scanp->scanner_id = $device->id;
            $scanp->enseignant_id = $ens->id;
            $scanp->date_scan = $date;
            $scanp->save();

            $this->saveScan($device->universite_id, $ens, $date);
        }

    }

    public function find_ens($matricule){
        $enseignant = Enseignant::where('matricule', $matricule)->get();
        if(count($enseignant) == 0){
            return null;
        }
        return $enseignant[0];
    }

    function univ_for_device($dev){
        $scanner = Scanner::where('num_serie', $dev)->get()->first();
        return $scanner;
    }

    function saveScan($universite_id, $ens, $dthr){
        $ens_id = $ens->id;
        $minutes = 5;
        $ens = Enseignant::find($ens_id);
        if ($ens == null)
            return new ScanPresence();
        $dthr_php = date_create_from_format('Y-m-d H:i:s', $dthr);

        $dt = date_format($dthr_php, 'Y-m-d');
        $hr = date_format($dthr_php, 'H:i:s');
        $hr_avt = date_format(date_sub(date_create_from_format('H:i:s', $hr),
            date_interval_create_from_date_string("$minutes minutes")), 'H:i:s');
        $hr_apr = date_format(date_add(date_create_from_format('H:i:s', $hr),
            date_interval_create_from_date_string("$minutes minutes")), 'H:i:s');

        $sce = null;

        $dpl = Deplacement::where('date_debut', '>=', $dt)
            ->where('date_fin', '<=', $dt)
            ->where('enseignant_id', $ens_id)
            ->where('universite_id', $universite_id);

        if ($dpl->count() == 0){
            $sce = DB::table('Seance')->where("enseignant_id", "$ens_id")
                ->where('universite_id', $universite_id)
                ->where('date_debut', '<=', $dt)
                ->where('date_fin', '>=', $dt)
                ->where('heure_debut', '<=', $hr_apr)
                ->where('heure_fin', '>=', $hr_avt)
                ->where('jour_semaine', date_format($dthr_php, "N"))
                ->whereNotIn('id', function($query) use($dt){
                    return $query->select('seance_id')->from('ScanPresence')
                        ->where('date_scan', $dt)
                        ->whereNotNull('heure_scan_fin');
                })
                ->first();
        }

        $sp = ScanPresence::when($sce, function($query) use ($sce){
            return $query->where('seance_id', $sce->id);
        })->where('enseignant_id', $ens_id)
            ->where('date_scan', $dt)
            ->where('heure_scan_deb', '<', $dthr)
            ->whereNull('heure_scan_fin')
            ->orderBy('heure_scan_deb', 'DESC')
            ->first();

        try {
            DB::beginTransaction();
            if ($sp){
                $old_seance_id = $sp->seance_id;
                $new_seance_id = ($sce) ? $sce->id : 0;
                if ($old_seance_id == 0){
                    $sp->seance_id = $new_seance_id;
                }
                $sp->heure_scan_fin = $dthr;
                $db = date_create($sp->heure_scan_deb);
                // $diff = date_diff($db, $dthr_php);
                // $nbHr = $diff->format("%H:%i");
                // $sp->nb_hr = $nbHr;
                $diff_in_seconds = $dthr_php->getTimestamp() - $db->getTimestamp();
                $h = floor($diff_in_seconds / 36) / 100;
                $sp->nb_hr = $h;


                if ($old_seance_id == 0)
                    $sp->nb_hr_cpt = 0;
                else {
                    if ($new_seance_id == 0){
                        $sp->nb_hr_cpt = 0;
                    } else {
                        $db = date_create($sp->heure_scan_deb);
                        $df = date_create_from_format("Y-m-d H:i:s", "{$dt} {$sce->heure_fin}");
                        if ($df > $dthr_php)
                            $df = $dthr_php;
                        // $diff = date_diff($db, $df);
                        // $nbHr = $diff->format("%H:%i");
                        // $sp->nb_hr_cpt = $nbHr;
                        $diff_in_seconds = $df->getTimestamp() - $db->getTimestamp();
                        $h = floor($diff_in_seconds / 36) / 100;
                        $sp->nb_hr_cpt = $h;
                    }
                }
            } else {
                $sp = new ScanPresence();
                $sp->seance_id = ($sce) ? $sce->id : 0;
                $sp->universite_id = $universite_id;
                $sp->enseignant_id = $ens_id;
                $sp->date_scan = $dt;
                $sp->heure_scan_deb = $dthr;
            }

            $sp->save();
            /**/
            /**/
            DB::commit();
        } catch (Throwable $e){
            DB::rollback();
            return 0;
        }

        return $sp;
    }

}

