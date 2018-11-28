<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 5/10/2017
 * Time: 2:01 PM
 */

namespace App\Events;

/**
 * Class EventSettings
 * 事件的设置，比如频道的设置
 * @package App\Events
 */
trait EventSettings
{
    protected $postLoginChannel = 'interviewerPostLoginChannel';

    protected $getLogoutChannel = 'interviewerGetLogoutChannel';

    protected $updateSignerListChannel = 'updateSignerListChannel';

    protected $messageToReceptionChannel = 'messageToReceptionChannel';
}