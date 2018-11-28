<?php

namespace App\Events;

use App\Group;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class InterviewerLogoutEvent
 * 广播面试官退出事件
 * @package App\Events
 */
class InterviewerLogoutEvent extends InterviewerEvent implements ShouldBroadcast
{
    use SerializesModels, EventSettings;

    public $group;
    /**
     * Create a new event instance.
     * @param Group $group
     * @return void
     */
    public function __construct(Group $group)
    {
        //
        $this->group = $group->toArray();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [ $this->getLogoutChannel ];
    }

    public function broadcastWith()
    {
        return $this->group;
    }
}
