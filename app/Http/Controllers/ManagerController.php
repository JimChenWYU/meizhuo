<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Events\InterviewerLogoutEvent;
use App\Group;
use App\Http\Controllers\Traits\TApplicant;
use App\Http\Controllers\Traits\TSigner;

/**
 * Class ManagerController
 * 管理后台控制器
 * @package App\Http\Controllers
 */
class ManagerController extends Controller
{
    use TApplicant, TSigner;
    /**
     * ManagerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 显示面试官登陆情况
     *
     * @return $this
     */
    public function interviewer()
    {
        $group = Group::get();

        if (isset($group) && $group = $group->toArray()) {
            return view('auth.interviewer.interviewers')
                ->with('interview', true)
                ->with('name', '面试组别')
                ->with('group', $group);
//            dd($group);
        }
        return view('auth.interviewer.interviewers')
            ->with('interview', true)
            ->with('name', '面试组别')
            ->with('group', []);
    }

    /**
     * 强制面试官退出
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function forceLogout($id)
    {
        if ($id) {
            $group = Group::where('id', $id)->first();

            Group::where('id', $id)->update([
                'unique_id' => '',
                'is_login' => 0
            ]);

            if (isset($group)) {
                event(new InterviewerLogoutEvent($group));
            }

            return redirect()->action('ManagerController@interviewer');
        }

        return redirect('/auth/interviewer')->withErrors([ 'msg' => '操作失败！' ]);
    }

    /**
     * 获取报名同学个人信息
     *
     * @param $id
     * @return $this
     */
    public function person($id)
    {
        $personObject = Applicant::where('id', $id)->first();
        if (! is_null($personObject)) {
            $personArray = $personObject->toArray();
            return view('auth.person')->with('person', $personArray);
        }
        return redirect('/auth/home')
            ->withErrors([ 'msg' => '没有找到该同学报名信息！' ]);
    }
}
