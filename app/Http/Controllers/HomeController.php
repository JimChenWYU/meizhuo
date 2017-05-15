<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class HomeController
 * 主页控制器
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * 首页报名页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return redirect()->action('HomeController@apply');
    }

    /**
     * 报名页面，通过配置环境变量来关闭报名系统
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply()
    {
        if (env('APP_DOWN_APPLY', false)) {
            return view('errors.endSign');
        } else {
            return view('home.apply');
        }
    }
}
