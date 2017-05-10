<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    //
    /**
     * @var array
     */
    protected $fillable = [ 'student_id', 'name', 'major', 'phone_num', 'grade', 'department', 'introduce' ];

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }
}
