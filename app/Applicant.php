<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Applicant
 * 报名者model类
 * @package App
 */
class Applicant extends Model
{
    //
    /**
     * 可填充字段
     * @var array $fillable
     */
    protected $fillable = [ 'student_id', 'name', 'major', 'phone_num', 'grade', 'department', 'introduce' ];

    /**
     * 一次性设置多个字段的值
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }
}
