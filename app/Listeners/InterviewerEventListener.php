<?php

namespace App\Listeners;

use App\Events\InterviewerEvent;
use App\Events\InterviewerLoginEvent;
use App\Events\InterviewerLogoutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class InterviewerEventListener
 * 面试官事件监听
 * @package App\Listeners
 */
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
        // 日志记录
        if ($event instanceof InterviewerLoginEvent) {
            app('log')->info('interviewer login : ' . json_encode($event->group));
        } else if ($event instanceof InterviewerLogoutEvent) {
            app('log')->info('interviewer logout : ' . json_encode($event->group));
        }
    }
}
