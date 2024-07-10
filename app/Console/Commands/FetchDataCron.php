<?php

namespace App\Console\Commands;

use App\Models\Enseignant;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        $url = "http://13.213.68.48:8081/iclock/api/transactions";
        $token = "JWT eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiY2ViYjRmNzgtMjI1OS0xMWVmLWE4OTYtMDI0YmU1MzBjNzZjIiwidXNlcm5hbWUiOiJhZG1pbiIsImV4cCI6MTcyMTA2NTIwMCwiZW1haWwiOiJhZG1pbkB6a3RlY28uY29tIiwib3JpZ19pYXQiOjE3MjA0NjA0MDB9.JK16PqHc4Jl5bKYOQvCMoGT-RbVky0rdxPybj7ABKUs";

        $this->fetchAndProcessData($url, $token);
    }

    private function fetchAndProcessData($url, $token): void
    {
        $response = Http::withHeaders([
            'Authorization' => $token
        ])->get($url);

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

    private function seance_matching($emp){
        $enseignant = Enseignant::find($emp);

    }
}
