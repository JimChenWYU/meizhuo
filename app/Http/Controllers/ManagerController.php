<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Events\InterviewerLogoutEvent;
use App\Group;
use App\Signer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class ManagerController extends Controller
{
    /**
     * ManagerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signerObject = Applicant::paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.home')
            ->with('all', true)
            ->with('departmentName', '所有人')
            ->with('department', $signerArray);
    }

    public function android()
    {
        $signerObject = Applicant::where('department', '移动组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.department.android')
            ->with('android', true)
            ->with('departmentName', '安卓组')
            ->with('department', $signerArray);
    }

    public function web()
    {
        $signerObject = Applicant::where('department', 'Web组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.department.web')
            ->with('web', true)
            ->with('departmentName', 'Web组')
            ->with('department', $signerArray);
    }

    public function design()
    {
        $signerObject = Applicant::where('department', '美工组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.department.design')
            ->with('design', true)
            ->with('departmentName', '美工组')
            ->with('department', $signerArray);
    }

    public function marking()
    {
        $signerObject = Applicant::where('department', '营销策划')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.department.marking')
            ->with('marking', true)
            ->with('departmentName', '营销策划')
            ->with('department', $signerArray);
    }

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

    public function forceLogout($id)
    {
        if ($id) {
            $group = Group::where('unique_id', $id)->first();

            Group::where('unique_id', $id)->update([
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

    public function person(Request $request, $id)
    {
        $personObject = Applicant::where('id', $id)->first();
        if (! is_null($personObject)) {
            $personArray = $personObject->toArray();
            return view('auth.person')->with('person', $personArray);
        }
        return redirect('/auth/home')
            ->withErrors([ 'msg' => '没有找到该同学报名信息！' ]);
    }

    public function postSearch(Request $request)
    {
        $this->validate($request, [
           'search' => 'required'
        ]);
        $parameters = $request->only(['search']);

        $signerObject = Applicant::whereRaw(sprintf("LOCATE('%s', name) > 0", $parameters['search']))
            ->orWhereRaw(sprintf("LOCATE('%s', student_id) > 0", $parameters['search']))->paginate(10);

        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.home')
            ->with('search', true)
            ->with('departmentName', "搜索 `{$parameters['search']}`")
            ->with('department', $signerArray);
    }

    public function getSearch()
    {
        return redirect('/auth/home');
    }
}
