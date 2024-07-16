<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\FetchDataJob;
use Illuminate\Support\Facades\Schedule;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();

//Schedule::job(new FetchDataJob(), 'transactions', 'database')->everyFiveMinutes();

Schedule::command('fetchData:cron')->everyFiveMinutes();
