<?php

namespace App\Console\Commands;

use App\Models\Deplacement;
use App\Models\Enseignant;
use App\Models\Logs;
use App\Models\Scanner;
use App\Models\ScanPresence;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class FetchDataCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetchData:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch data cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        info("Cron Job running at ". now());
        $time = Carbon::now();
        $time5 = $time->subMinutes(5);
        $log= new Logs();
        $log->contenu = "$time";
        $log->type = "$time";
        $log->save();
        $url = "http://13.213.68.48:8081/iclock/api/transactions";
        $token = "JWT eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiY2ViYjRmNzgtMjI1OS0xMWVmLWE4OTYtMDI0YmU1MzBjNzZjIiwidXNlcm5hbWUiOiJhZG1pbiIsImV4cCI6MTcyMTA2NTIwMCwiZW1haWwiOiJhZG1pbkB6a3RlY28uY29tIiwib3JpZ19pYXQiOjE3MjA0NjA0MDB9.JK16PqHc4Jl5bKYOQvCMoGT-RbVky0rdxPybj7ABKUs";

        $this->fetchAndProcessData($url, $token, $time5, $time);
    }

    private function fetchAndProcessData($url, $token, $start_time, $end_time): void
    {
        $response = Http::withHeaders([
            'Authorization' => $token
        ])->get($url, [
            'start_time' => $start_time,
            'end_time' => $end_time,
        ]);
        $log= new Logs();
        $log->contenu = $response->effectiveUri();
        $log->type = $response->effectiveUri();
        $log->save();

        if ($response->successful()) {
            $responseData = $response->json();

            if (isset($responseData['data']) && $responseData['data'] != null) {
                $data = $responseData['data'];

                foreach ($data as $datum) {
                    Transaction::create([
                        "emp_code" => $datum["emp_code"],
                        "punch_time" => $datum["punch_time"],
                        "punch_state" => $datum["punch_state"],
                        "verify_type" => $datum["verify_type"],
                        "work_code" => $datum["work_code"],
                        "terminal_sn" => $datum['terminal_sn'],
                        "terminal_alias" => $datum['terminal_alias'],
                        "area_alias" => $datum['area_alias'],
                        "longitude" => $datum['longitude'],
                        "latitude" => $datum['latitude'],
                        "gps_location" => $datum['gps_location'],
                        "mobile" => $datum['mobile'],
                        "source" => $datum['source'],
                        "purpose" => $datum['purpose'],
                        "crc" => $datum['crc'],
                        "is_attendance" => $datum['is_attendance'],
                        "reserved" => $datum['reserved'],
                        "sync_status" => $datum['sync_status'],
                        "sync_time" => $datum['sync_time'],
                        "company" => $datum['company'],
                        "emp" => $datum["terminal"]
                    ]);

                    $universite = Scanner::where('num_serie', $datum['terminal_sn'])->get();
                    $this->saveScan($universite, $datum['emp_code'], $datum["punch_time"]);
                }

                if (isset($responseData['next']) && $responseData['next'] != null) {
                    $this->fetchAndProcessData($responseData['next'], $token);
                }
            } else {
                logger()->error('La clé "data" est manquante dans la réponse', ['response' => $responseData]);
            }
        } else {
            logger()->error('Erreur lors de la requête GET', ['response' => $response]);
        }
    }


    public function saveScan($universite_id, $ens_id, $dthr){
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

            DB::commit();
        } catch (Throwable $e){
            DB::rollback();
            return 0;
        }

        return $sp;
    }
}
