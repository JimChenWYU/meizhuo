<?php

namespace App\Http\Controllers\Api;

use App\Signer;
use App\Transformers\SignTransformer;
use Illuminate\Http\Request;

class SignController extends ApiController
{
    protected static $grade = [ '大一', '大二' ];
    protected static $department = [ '移动组', 'Web组', '美工组', '营销策划' ];

    protected static $message = [
        'student_id.required' => '请合法填写您的学号',
        'student_id.digits' => '请合法填写您的学号',

        'name.required' => '请合法填写您的姓名',
        'name.string' => '请合法填写您的姓名',
        'name.max' => '请合法填写您的姓名',

        'major.required' => '请合法填写您的专业',
        'major.string' => '请合法填写您的专业',
        'major.max' => '请合法填写您的专业',

        'phone_num.required' => '请合法填写您的联系方式',
        'phone_num.string' => '请合法填写您的联系方式',
        'phone_num.max' => '请合法填写您的联系方式',

        'grade.required' => '请合法选择您的年级',
        'grade.string' => '请合法选择您的年级',

        'department.required' => '请合法选择面试部门',
        'department.string' => '请合法选择面试部门',

        'introduce.string' => '请填写不多于300字的简介',
        'introduce.max' => '请填写不多于300字的简介',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        return $this->setStatusCode(400)->respondWithError('hahaha', self::CODE_WRONG_ARGS);
//        return $this->setStatusCode(400)->respondWithArray(['name' => 'Jim', 'age' => 12]);
//        return $this->setStatusCode(400)->respondWithCollection(['name' => 'Jim', 'age' => 12], function (){});
//        return $this->setStatusCode(400)->respondWithItem("msg", function (){});
//        return 'Hello';
    }

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

        $signer = new Signer();
        $signer->setAttributes($parameters = $request->all());
        if (is_null($first = Signer::whereStudentId($parameters['student_id'])
                                        ->whereDepartment($parameters['department'])
                                        ->first())) {
            $signer->save();
        }
//        dd($first->toArray());

        return $this->respondWith($signer, new SignTransformer);
    }
}
