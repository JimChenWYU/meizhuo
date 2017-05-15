<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class MessageToReceptionEvent
 * 广播通知前台工作人员
 * @package App\Events
 */
class MessageToReceptionEvent extends Event implements ShouldBroadcast
{
    use SerializesModels, EventSettings;

    public $sender;

    /**
     * Create a new event instance.
     * @param array $sender
     * @return void
     */
    public function __construct(array $sender)
    {
        //
        $this->sender = $sender;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [ $this->messageToReceptionChannel ];
    }

    public function broadcastWith()
    {
        return $this->sender;
    }
}
