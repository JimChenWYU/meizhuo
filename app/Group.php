<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * 面试官model类
 * @property $unique_id
 * @property $department
 * @property $number
 * @package App
 */
class Group extends Model
{
    /**
     * 对应的表名
     * @var string $table
     */
    protected $table = 'interview_group';
}
