<?php

namespace App\Http\Controllers\Api;

use App\Applicant;
use App\Events\InterviewerLoginEvent;
use App\Events\InterviewerLogoutEvent;
use App\Events\MessageToReceptionEvent;
use App\Events\UpdateSignerListEvent;
use App\Group;
use App\Signer;
use App\Transformers\ApplicantTransformer;
use App\Transformers\SignTransformer;
use Illuminate\Http\Request;

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
            ->first();

        if (count($first)) {

            if (is_null($first['unique_id']) || empty($first['unique_id'])) {
                Group::where('department', $parameters['department'])
                    ->where('number', $parameters['number'])
                    ->update([
                        'unique_id' => $parameters['unique_id'],
                        'is_login' => 0
                    ]);
            } else {
                Group::where('department', $parameters['department'])
                    ->where('number', $parameters['number'])
                    ->update([
                        'is_login' => 1
                    ]);
            }

            $group = Group::where('department', $parameters['department'])
                ->where('number', $parameters['number'])
                ->first();

            $group->unique_id = $parameters['unique_id'];

            $this->eventLoginFire($group);

            $token = sprintf('bearer %s', \JWTAuth::fromUser($group));

            return $this->respondWithArray(array_merge($group->toArray(), compact('token')), [
                'Authorization' => $token
            ]);
        }

        return $this->respondWithError('登录失败！', 400);
    }

    public function getLogout()
    {
        $parameters = \JWTAuth::parseToken()->toUser()->toArray();

        $group = Group::where('department', $parameters['department'])
            ->where('number', $parameters['number'])
            ->first();

        Group::where('department', $parameters['department'])
            ->where('number', $parameters['number'])
            ->update([
                'unique_id' => '',
                'is_login' => 0
            ]);

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

                $sender = [
                    'unique_id' => $parameters['unique_id'],
                    'department' => $parameters['department'],
                    'number' => $parameters['number'],
                    'msg' => sprintf('通知下一位面试者到 %s %d', $parameters['department'], $parameters['number']),
                ];

                $this->eventUpdateSignerList($dataList);
                $this->eventMessageFire($sender);

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
//        dd($group->toArray());
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
     * 发送消息通知前台面试
     *
     * @param array $sender
     */
    protected function eventMessageFire(array $sender)
    {
        event(new MessageToReceptionEvent($sender));
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
