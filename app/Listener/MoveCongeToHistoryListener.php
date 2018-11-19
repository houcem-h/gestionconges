<?php

namespace App\Listener;

use App\Events\MoveCongeToHistory;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MoveCongeToHistoryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MoveCongeToHistory  $event
     * @return void
     */
    public function handle(MoveCongeToHistory $event)
    {
        //
    }    
}
