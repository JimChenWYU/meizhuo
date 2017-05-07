<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Routing\Router;

Route::get('/', function () {
    return view('welcome');
});

Route::group([ 'prefix' => 'api', 'namespace' => 'Api' ], function (Router $router) {
    $router->group([ 'prefix' => 'v1' ], function (Router $router) {
        $router->post('sign', [ 'uses' => 'SignController@store' ]);
    });
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'sign'], function (Router $router) {
    $router->get('/{vue_capture?}', function () {
        return view('home.sign');
    })->where('vue_capture', '[\/\w\.-]*');
});

Route::group(['prefix' => 'auth'], function (Router $router) {

    $router->group([ 'namespace' => 'Auth' ], function (Router $router) {
        $router->get('login', 'AuthController@getLogin');
        $router->post('login', 'AuthController@postLogin');
        $router->get('logout', 'AuthController@getLogout');
    });

    $router->get('home', 'ManagerController@index');

    // 注册路由...
    if (! config('auth.registered')) {
        $router->get('register', 'AuthController@getRegister');
        $router->post('register', 'AuthController@postRegister');
    }
});
