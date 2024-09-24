<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Scan;
use App\Models\ScanPresence;
use App\Models\Scanner;
use App\Models\Deplacement;
use App\Models\Enseignant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExecController extends Controller
{
    private $types;

    public function __construct()
    {
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

    public function heartbeat(Request $request)
    {
        $headers_data = getallheaders();
        $body_data = $request->all();

        if (!isset($headers_data['request_code']) || $headers_data['request_code'] !== 'receive_cmd') {
            return response()->json([
                'response_code' => 'ERROR_NO_CMD'
            ]);
        }

        $device = $this->univ_for_device($headers_data['dev_id']);
        if (!$device) {
            return response()->json([
                'response_code' => 'ERROR_NO_CMD'
            ]);
        }

        $log = new Logs();
        $log->contenu = json_encode($body_data);
        $log->type = json_encode($headers_data);
        $log->dev_id = $request->time;
        $log->save();

        $beginTime = $body_data['beginTime'] ?? null;
        $endTime = $body_data['endTime'] ?? null;

        $logs = $this->getLogsFromDevice($device->id, $beginTime, $endTime);

        if (empty($logs)) {
            return response()->json([
                'response_code' => 'ERROR_NO_CMD'
            ]);
        }

        return response()->json([
            "packageId" => 0, 
            "allLogCount" => count($logs),
            "logsCount" => count($logs),
            "logs" => $logs
        ]);
    }

    protected function getLogsFromDevice($dev_id, $beginTime, $endTime)
    {
        $query = Scan::where('device_id', $dev_id);

        if ($beginTime) {
            $query->where('time', '>=', Carbon::createFromFormat('Ymd', $beginTime));
        }
        if ($endTime) {
            $query->where('time', '<=', Carbon::createFromFormat('Ymd', $endTime));
        }

        return $query->get()->map(function ($log) {
            return [
                "userId" => $log->user_id,
                "time" => Carbon::parse($log->time)->format('YmdHis'),
                "verifyMode" => $log->verify_mode,  
                "ioMode" => $log->io_mode,  
                "inOut" => $log->in_out,  
                "doorMode" => $log->door_mode,  
                "temperature" => $log->temperature,  
                "logPhoto" => $log->log_photo  
            ];
        })->toArray();
    }

    public function send_cmd_result(Request $request)
    {
        $headers_data = getallheaders();

        if (!isset($headers_data['request_code']) || $headers_data['request_code'] !== 'send_cmd_result') {
            return response()->json([
                'response_code' => 'ERROR_NO_CMD'
            ]);
        }

        return response()->json([
            'response_code' => 'OK',
            'trans_id' => $headers_data['trans_id'] ?? '100'
        ]);
    }

    public function univ_for_device($dev)
    {
        return Scanner::where('num_serie', $dev)->first();
    }

    public function saveScan($universite_id, $ens, $dthr)
    {
        $ens_id = $ens->id;
        $dthr_php = date_create_from_format('Y-m-d H:i:s', $dthr);
        $dt = date_format($dthr_php, 'Y-m-d');
        $hr = date_format($dthr_php, 'H:i:s');
        $hr_avt = date_format(date_sub(date_create_from_format('H:i:s', $hr), date_interval_create_from_date_string("5 minutes")), 'H:i:s');
        $hr_apr = date_format(date_add(date_create_from_format('H:i:s', $hr), date_interval_create_from_date_string("5 minutes")), 'H:i:s');

        $sce = DB::table('Seance')
            ->where("enseignant_id", $ens_id)
            ->where('universite_id', $universite_id)
            ->where('date_debut', '<=', $dt)
            ->where('date_fin', '>=', $dt)
            ->where('heure_debut', '<=', $hr_apr)
            ->where('heure_fin', '>=', $hr_avt)
            ->where('jour_semaine', date_format($dthr_php, "N"))
            ->first();

        $sp = ScanPresence::when($sce, function ($query) use ($sce) {
            return $query->where('seance_id', $sce->id);
        })
            ->where('enseignant_id', $ens_id)
            ->where('date_scan', $dt)
            ->whereNull('heure_scan_fin')
            ->orderBy('heure_scan_deb', 'DESC')
            ->first();

        DB::beginTransaction();
        try {
            if ($sp) {
                $sp->heure_scan_fin = $dthr;
                $diff_in_seconds = $dthr_php->getTimestamp() - date_create($sp->heure_scan_deb)->getTimestamp();
                $sp->nb_hr = floor($diff_in_seconds / 3600);
                $sp->save();
            } else {
                $sp = new ScanPresence();
                $sp->seance_id = $sce ? $sce->id : 0;
                $sp->universite_id = $universite_id;
                $sp->enseignant_id = $ens_id;
                $sp->date_scan = $dt;
                $sp->heure_scan_deb = $dthr;
                $sp->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Transaction failed', 'message' => $e->getMessage()], 500);
        }
        return $sp;
    }
}
