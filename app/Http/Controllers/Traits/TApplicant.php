<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 5/15/2017
 * Time: 4:11 PM
 */

namespace App\Http\Controllers\Traits;

use App\Applicant;
use Illuminate\Http\Request;

/**
 * Class TApplicant
 * 对报名同学相关查看操作
 * @package App\Http\Controllers\Traits
 */
trait TApplicant
{
    protected $apply_settings = [
        'root' => 'auth.applicant'
    ];

    /**
     * 管理后台首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signerObject = Applicant::paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.home')
            ->with('settings', $this->apply_settings)
            ->with('all', true)
            ->with('departmentName', '所有人')
            ->with('department', $signerArray);
    }

    /**
     * 显示安卓组报名同学
     *
     * @return $this
     */
    public function android()
    {
        $signerObject = Applicant::where('department', '移动组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.department.android')
            ->with('settings', $this->apply_settings)
            ->with('android', true)
            ->with('departmentName', '安卓组')
            ->with('department', $signerArray);
    }

    /**
     * 显示web组报名同学
     *
     * @return $this
     */
    public function web()
    {
        $signerObject = Applicant::where('department', 'Web组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.department.web')
            ->with('settings', $this->apply_settings)
            ->with('web', true)
            ->with('departmentName', 'Web组')
            ->with('department', $signerArray);
    }

    /**
     * 显示design（美工）组报名同学
     *
     * @return $this
     */
    public function design()
    {
        $signerObject = Applicant::where('department', '美工组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.department.design')
            ->with('settings', $this->apply_settings)
            ->with('design', true)
            ->with('departmentName', '美工组')
            ->with('department', $signerArray);
    }

    /**
     * 显示marking（营销策划）组报名同学
     *
     * @return $this
     */
    public function marking()
    {
        $signerObject = Applicant::where('department', '营销策划')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.department.marking')
            ->with('settings', $this->apply_settings)
            ->with('marking', true)
            ->with('departmentName', '营销策划')
            ->with('department', $signerArray);
    }

    /**
     * 根据学号或姓名搜索报名同学
     *
     * @param Request $request
     * @return $this
     */
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
            ->with('settings', $this->apply_settings)
            ->with('search', true)
            ->with('departmentName', "搜索 `{$parameters['search']}`")
            ->with('department', $signerArray);
    }

    /**
     * 搜索模板页面重定向
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getSearch()
    {
        return redirect('/auth/home');
    }
}