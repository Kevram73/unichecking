<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\ProcessDataEvent;
use App\Listeners\ProcessDataListener;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
		Event::listen(
			ProcessDataEvent::class,
			ProcessDataListener::class,
		);
    }
}