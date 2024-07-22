<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;
use App\Models\MachineLog;

class ExecController extends Controller
{
    public function __construct()
    {
        $this->types = [
            1 => "GET_DEVICE_INFO",
            2 => "GET_USER_ID_LIST",
            3 => "GET_LOG_DATA",
            4 => "CLEAR_LOG_DATA",
            5 => "RESET_FK",
            6 => "ENTER_ENROLL",
        ];
    }

    public function realtime_exec(Request $request, int $params){

        $nfo = $request->all();
        $le_type = count($nfo) > 1 ? 1 : 2;

        if ($le_type == 1){
            return response("")
                ->withHeaders([
                    'response_code' => "OK",
                    'trans_id' => rand(100,100000),
                ]);
        } else
            return response("")
                ->withHeaders([
                    'response_code' => "OK",
                    'trans_id' => rand(100,100000),
                    'cmd_code' => $this->types[$params]
                ]);
    }

    public function realtime(Request $request){
        logger($request->all());
        $newLog = new Logs();
        $newLog->contenu = file_get_contents("php://input");
        $newLog->type = json_encode($request->headers->all());
        $newLog->save();
        return response("hello", 200)->withHeaders([
            'Content-Type' => 'application/json',
            'response_code' => 'OK',
            'trans_id' => 010011
        ]);

//        $headers = $request->headers->all();
//        $device = "";
//        foreach ($headers as $key => $value) {
//            // Convertir les valeurs en chaîne de caractères pour l'affichage
//            $value = implode(", ", $value);
//            if($key == "deviceId")
//                $device = $value;
//        }
//        $machineLog = new MachineLog();
//        $machineLog->user_id = $request->userId;
//        $machineLog->time = $request->time;
//        $machineLog->verify_mode = $request->verifyMode;
//        $machineLog->io_mode = $request->ioMode;
//        $machineLog->in_out = $request->inOut;
//        $machineLog->door_mode = $request->doorMode;
//        $machineLog->log_photo = $request->logPhoto;
//        $machineLog->device_id = $request->device;
//        $machineLog->save();
    }
}
