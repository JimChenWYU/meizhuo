<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Signer
 * 签到者实体类
 * @package App
 */
class Signer extends Model
{
    /**
     * 可填充字段
     * @var array $fillable
     */
    protected $fillable = [ 'student_id', 'name', 'major', 'phone_num', 'grade', 'department', 'introduce', 'has_apply', 'status' ];

    /**
     * 一次性设置多个字段的值
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }
}
