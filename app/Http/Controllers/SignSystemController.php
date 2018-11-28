<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class SignSystemController
 * 前台签到系统控制器
 * @package App\Http\Controllers
 */
class SignSystemController extends Controller
{
    /**
     * 首页展示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('home.sign');
    }
}
