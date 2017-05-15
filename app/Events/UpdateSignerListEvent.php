<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class UpdateSignerListEvent
 * 广播更新前台签到者列表信息
 * @package App\Events
 */
class UpdateSignerListEvent extends Event implements ShouldBroadcast
{
    use SerializesModels, EventSettings;

    public $dataList;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $dataList)
    {
        //
        $this->dataList = $dataList;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [ $this->updateSignerListChannel ];
    }

    public function broadcastWith()
    {
        return $this->dataList;
    }
}
