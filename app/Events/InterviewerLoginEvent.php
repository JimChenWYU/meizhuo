<?php

namespace App\Events;

use App\Group;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class InterviewerLoginEvent extends InterviewerEvent implements ShouldBroadcast
{
    use SerializesModels, EventSettings;

    public $group;

    /**
     * Create a new event instance.
     *
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        //
        $this->group = $group;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [ $this->postLoginChannel ];
    }

    public function broadcastWith()
    {
        return $this->group->toArray();
    }
}
