<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signer extends Model
{
    /**
     * @var array
     */
    protected $fillable = [ 'student_id', 'name', 'major', 'phone_num', 'grade', 'department', 'introduce', 'has_apply', 'status' ];

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }
}
