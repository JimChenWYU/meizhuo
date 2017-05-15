<?php

namespace App\Http\Controllers\Api;

use App\Applicant;
use App\Transformers\ApplicantTransformer;
use Illuminate\Http\Request;

/**
 * Class ApplicantController
 * 报名者控制器
 * @package App\Http\Controllers\Api
 */
class ApplicantController extends ApiController
{
    use Condition;
    /**
     * 报名api
     *
     * @param Request $request
     * @return \Response
     */
    public function store(Request $request)
    {
        if (env('APP_DOWN_SIGN', false)) {
            return $this->respondWithMsg('报名已结束');
        }
        // 验证
        $this->validate($request, [
            'student_id' => 'required | digits:10',
            'name' => 'required | string | max:8',
            'major' => 'required | string | max:16',
            'phone_num' => 'required | string | max:32',
            'grade' => 'required | string | in:' . implode(',', self::$grade),
            'department' => 'required | string | in:' . implode(',', self::$department),
            'introduce' => 'string | max:300'
        ], self::$message);

        // 通过model类保存
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
