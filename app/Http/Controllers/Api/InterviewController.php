<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class InterviewController extends ApiController
{
    use Condition;

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'department' => 'required | string | in:' . implode(',', self::$department),
            'number' => 'required | numeric'
        ], [
            'department.required' => '请合法选择面试部门',
            'department.string' => '请合法选择面试部门',

            'number.required' => '请合法选择面试部门组别',
            'number.numeric' => '请合法选择面试部门组别',
        ]);

        $parameters = $request->only(['department', 'number']);

        $first = (array) \DB::table('interview_group')
            ->where('department', $parameters['department'])
            ->where('number', $parameters['number'])
            ->where('lock', 0)
            ->first();

        if (count($first)) {
            $flag = \DB::table('interview_group')
                ->where('department', $parameters['department'])
                ->where('number', $parameters['number'])
                ->update(['lock' => 1]);

            if ($flag) {
                return $this->respondWithMsg('登录成功！');
            }
        }
    }
}
