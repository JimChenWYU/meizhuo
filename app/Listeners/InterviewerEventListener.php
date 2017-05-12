<?php

namespace App\Listeners;

use App\Events\InterviewerEvent;
use App\Events\InterviewerLoginEvent;
use App\Events\InterviewerLogoutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterviewerEventListener
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
     * @param  InterviewerEvent  $event
     * @return void
     */
    public function handle(InterviewerEvent $event)
    {
        //
        if ($event instanceof InterviewerLoginEvent) {
            app('log')->info('interviewer login : ' . $event->group->toJson());
        } else if ($event instanceof InterviewerLogoutEvent) {
            app('log')->info('interviewer logout : ' . $event->group->toJson());
        }
    }
}
