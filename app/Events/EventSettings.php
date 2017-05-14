<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 5/10/2017
 * Time: 2:01 PM
 */

namespace App\Events;


trait EventSettings
{
    protected $postLoginChannel = 'interviewerPostLoginChannel';

    protected $getLogoutChannel = 'interviewerGetLogoutChannel';

    protected $updateSignerListChannel = 'updateSignerListChannel';

    protected $messageToReceptionChannel = 'messageToReceptionChannel';
}