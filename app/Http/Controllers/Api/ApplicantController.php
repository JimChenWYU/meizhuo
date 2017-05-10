<?php

namespace App\Http\Controllers\Api;

use App\Applicant;
use App\Transformers\ApplicantTransformer;
use Illuminate\Http\Request;


class ApplicantController extends ApiController
{
    use Condition;
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'student_id' => 'required | digits:10',
            'name' => 'required | string | max:8',
            'major' => 'required | string | max:16',
            'phone_num' => 'required | string | max:32',
            'grade' => 'required | string | in:' . implode(',', self::$grade),
            'department' => 'required | string | in:' . implode(',', self::$department),
            'introduce' => 'string | max:300'
        ], self::$message);

        $signer = new Applicant();
        $signer->setAttributes($parameters = $request->only($this->acceptParameters()));
        if (is_null($first = Applicant::whereStudentId($parameters['student_id'])
            ->whereDepartment($parameters['department'])
            ->first())) {
            $signer->save();
        }
//        dd($first->toArray());

        return $this->respondWith($signer, new ApplicantTransformer);
    }
}
