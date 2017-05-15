<?php

namespace App\Events;

use App\Group;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

/**
 * Class InterviewerLoginEvent
 * 广播面试官登陆事件
 * @package App\Events
 */
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
        // 必须这么做，无法在broadcastWith获取数组，
        // 不然修改的属性在toArray()之后无法生效
        // 意思是public $group保存Group实例，在broadcastWith返回$this->group->toArray()
        $this->group = $group->toArray();
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

    /**
     * 对事件广播数据进行粒度控制
     *
     * @return array
     */
    public function broadcastWith()
    {
        return $this->group;
    }
}
