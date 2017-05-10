<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return redirect()->action('HomeController@apply');
    }

    public function apply()
    {
        if (env('APP_DOWN_SIGN', false)) {
            return view('errors.endSign');
        } else {
            return view('home.apply');
        }
    }
}
