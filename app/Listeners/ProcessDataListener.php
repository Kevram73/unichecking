<?php

namespace App\Listeners;

use App\Events\ProcessDataEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Faculte;
use App\Models\Logs;

class ProcessDataListener implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    //public $queue = 'listeners';
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProcessDataEvent $event):void
    {
	$dt = now();
      for ($i = 0; $i < 1000; $i++){
		  $f = Faculte::with(['filieres', 'ues'])->get();
		  $l = new Logs();
		  $l->contenu="$dt - $$i = $i";
		  $l->type = "test";
		  $l->save();
	  }
    }
	 
    /**
     * Determine whether the listener should be queued.
     */
/*
    public function shouldQueue(ProcessDataEvent $event): bool
    {
        return 1 == 1;
    }
	*/
	
	
}
