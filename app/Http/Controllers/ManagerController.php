<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Signer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    /**
     * ManagerController constructor.
     */
    public function __construct()
    {
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

    public function person(Request $request, $id)
    {
        $personObject = Applicant::where('id', $id)->first();
        if (! is_null($personObject)) {
            $personArray = $personObject->toArray();
            return view('auth.person')->with('person', $personArray);
        }
        return redirect('/auth/home')
            ->withErrors([ 'not-found-person' => '没有找到该同学报名信息！' ]);
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
