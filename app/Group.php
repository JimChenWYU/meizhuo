<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 *
 * @property $unique_id
 * @property $department
 * @property $number
 * @package App
 */
class Group extends Model
{
    protected $table = 'interview_group';
}
