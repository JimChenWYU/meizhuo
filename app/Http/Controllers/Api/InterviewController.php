<?php

namespace App\Http\Controllers\Api;

use App\Applicant;
use App\Events\InterviewerLoginEvent;
use App\Events\InterviewerLogoutEvent;
use App\Events\UpdateSignerListEvent;
use App\Group;
use App\Signer;
use App\Transformers\ApplicantTransformer;
use App\Transformers\SignTransformer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class InterviewController extends ApiController
{
    use Condition;

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'unique_id' => 'required',
            'department' => 'required | string | in:' . implode(',', self::$department),
            'number' => 'required | numeric'
        ], [
            'unique_id.required' => '缺少唯一id',

            'department.required' => '请合法选择面试部门',
            'department.string' => '请合法选择面试部门',

            'number.required' => '请合法选择面试部门组别',
            'number.numeric' => '请合法选择面试部门组别',
        ]);

        $parameters = $request->only(['unique_id', 'department', 'number']);

        $first = (array) \DB::table('interview_group')
            ->where('department', $parameters['department'])
            ->where('number', $parameters['number'])
            ->where('lock', 0)
            ->first();

        if (count($first)) {

            $flag = Group::where('department', $parameters['department'])
                ->where('number', $parameters['number'])
                ->update(['unique_id' => $parameters['unique_id']]);

            if ($flag) {
//                dd(Group::first());
                $group = Group::where('department', $parameters['department'])
                    ->where('number', $parameters['number'])
                    ->first();

                $this->eventLoginFire($group);

                $token = sprintf('bearer %s', \JWTAuth::fromUser($group));

                return $this->respondWithArray(array_merge($group->toArray(), compact('token')), [
                    'Authorization' => $token
                ]);
            }
        }

        return $this->respondWithError('登录失败！', 400);
    }

    public function autoLogin() {

        $parameters = \JWTAuth::parseToken()->toUser()->toArray();

        if (count($parameters)) {
            $flag = Group::where('department', $parameters['department'])
                ->where('number', $parameters['number'])
                ->update(['unique_id' => $parameters['unique_id']]);

            if ($flag) {
//                dd(Group::first());
                $group = Group::where('department', $parameters['department'])
                    ->where('number', $parameters['number'])
                    ->first();

                $this->eventLoginFire($group);

                $token = sprintf('bearer %s', \JWTAuth::fromUser($group));

                return $this->respondWithArray(array_merge($group->toArray(), compact('token')), [
                    'Authorization' => $token
                ]);
            }
        }

        return $this->respondWithError('登录失败！', 400);
    }

    public function getLogout()
    {
        $parameters = \JWTAuth::parseToken()->toUser()->toArray();

        $group = Group::where('department', $parameters['department'])
            ->where('number', $parameters['number'])
            ->first();

        $this->eventLogoutFire($group);

        \JWTAuth::parseToken()->refresh();

        return $this->respondWithMsg('OK');
    }

    /**
     * 搜索
     *
     * @param Request $request
     * @return \Response
     */
    public function postSearch(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required | digits:10',
            'department' => 'required | string | in:' . implode(',', self::$department),
        ]);

        $parameters = $request->only(['student_id', 'department']);

        $signerObject = Signer::where('department', $parameters['department'])
            ->whereRaw(sprintf("LOCATE('%s', student_id) > 0", $parameters['student_id']))->first();

        if (!is_null($signerObject)) {
            return $this->respondWith($signerObject, new SignTransformer());
        }

        $signerObject = Applicant::where('department', $parameters['department'])
            ->whereRaw(sprintf("LOCATE('%s', student_id) > 0", $parameters['student_id']))->first();

        if (!is_null($signerObject)) {
            return $this->respondWith($signerObject, new ApplicantTransformer);
        }

        return $this->setStatusCode(404)->respondWithMsg('没有该同学记录');
    }

    /**
     * 开始新一轮面试
     *
     * @param Request $request
     * @return mixed|\Response
     */
    public function getSigner(Request $request)
    {
        $parameters = \JWTAuth::parseToken()->toUser()->toArray();

        $previous = $request->only(['current_signer_id']);

        if (! empty($previous['current_signer_id'])) {
            Signer::where('id', $previous['current_signer_id'])
                ->update(['status' => 4]);
        }

        $signer = Signer::where('department', $parameters['department'])
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->first();

        if (! is_null($signer)) {
            $flag = Signer::where('id', $signer->id)->update(['status' => 3]);
            if ($flag) {

                // 获得数组
                $dataList = app(SignController::class)->getSignersArray();

                $this->eventUpdateSignerList($dataList);

                $signer->status = 3;
                return $this->respondWith($signer, new SignTransformer());
            }
        } else {
            // 获得数组
            $dataList = app(SignController::class)->getSignersArray();

            $this->eventUpdateSignerList($dataList);
        }

        return $this->setStatusCode(404)
            ->respondWithError('没有签到者，请等一会再尝试！', 404);
    }

    /**
     * 登录触发事件
     *
     * @param Group $group
     */
    protected function eventLoginFire(Group $group)
    {
        event(new InterviewerLoginEvent($group));
    }

    /**
     * 退出触发事件
     *
     * @param Group $group
     */
    protected function eventLogoutFire(Group $group)
    {
        event(new InterviewerLogoutEvent($group));
    }

    /**
     * 更新签到表
     *
     * @param array $dataList
     */
    protected function eventUpdateSignerList(array $dataList)
    {
        event(new UpdateSignerListEvent($dataList));
    }

    public function testToken()
    {
        $payload = \JWTAuth::parseToken()->toUser()->toArray();
        dd($payload);
    }
}
