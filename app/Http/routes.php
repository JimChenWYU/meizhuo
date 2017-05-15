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

Route::get('/', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| Api路由
|--------------------------------------------------------------------------
*/
Route::group([ 'namespace' => 'Api' ], function (Router $router) {
    $router->group([ 'prefix' => 'api/v1' ], function (Router $router) {
        // 报名路由
        $router->post('apply', [ 'uses' => 'ApplicantController@store' ]);
        // 签到路由
        $router->post('sign', [ 'uses' => 'SignController@sign' ]);

        // 获取所有签到者路由
        $router->get('signers', [ 'uses' => 'SignController@getSignersByDepartment' ]);

        // 删除已经签到者路由
        $router->delete('signer', [ 'uses' => 'SignController@deleteSignersById' ]);

        // 更新签到者状态路由（排队 or 面试）
        $router->put('signer', [ 'uses' => 'SignController@restoreSignerStatus' ]);

        // 面试官登录路由
        $router->post('interview', 'InterviewController@postLogin');

        // 面试官退出路由
        $router->get('interview/', 'InterviewController@getLogout')->middleware('jwt.auth');

        // 面试官搜索路由
        $router->post('interview/search', 'InterviewController@postSearch');

        // 面试官获取签到者路由
        $router->get('interview/signer', 'InterviewController@getSigner')->middleware('jwt.auth');

        // 测试
        if (env('APP_DEBUG', false)) {
            $router->get('interview/test', 'InterviewController@testToken')->middleware('jwt.auth');
        }
    });
});

/*
|--------------------------------------------------------------------------
| 签到前台路由
|--------------------------------------------------------------------------
*/

// 签到页面
Route::get('sign/{vue_capture?}', 'SignSystemController@index')->where('vue_capture', '[\/\w\.-]*');

// 面试官页面
Route::get('interview/{vue_capture?}', 'SignSystemController@index')->where('vue_capture', '[\/\w\.-]*');

// 报名页面
Route::get('apply/{vue_capture?}', 'HomeController@apply')->where('vue_capture', '[\/\w\.-]*');

/*
|--------------------------------------------------------------------------
| 后台管理路由
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth'], function (Router $router) use ($app) {

    $router->group([ 'namespace' => 'Auth' ], function (Router $router) use ($app) {
        $router->get('/', 'AuthController@getLogin');

        // 管理员登陆路由
        $router->get('login', 'AuthController@getLogin');
        $router->post('login', 'AuthController@postLogin');
        $router->get('logout', 'AuthController@getLogout');

        // 注册管理员路由...
        // 生产环境下禁用
        if ($app->isLocal()) {
            $router->get('register', 'AuthController@getRegister');
            $router->post('register', 'AuthController@postRegister');
        }
    });

    // 管理报名同学路由
    $router->get('home', 'ManagerController@index');
    $router->get('android', 'ManagerController@android');
    $router->get('web', 'ManagerController@web');
    $router->get('design', 'ManagerController@design');
    $router->get('marking', 'ManagerController@marking');
    $router->get('person/{id}', 'ManagerController@person')->where('id', '[0-9]+');
    $router->get('home/{id}', 'ManagerController@person')->where('id', '[0-9]+');
    $router->get('android/{id}', 'ManagerController@person')->where('id', '[0-9]+');
    $router->get('web/{id}', 'ManagerController@person')->where('id', '[0-9]+');
    $router->get('design/{id}', 'ManagerController@person')->where('id', '[0-9]+');
    $router->get('marking/{id}', 'ManagerController@person')->where('id', '[0-9]+');
    $router->get('search', 'ManagerController@getSearch');
    $router->post('search', 'ManagerController@postSearch');

    // 管理面试官路由
    $router->get('interviewer', 'ManagerController@interviewer');
    $router->post('interviewer/{unique_id}', 'ManagerController@forceLogout')->where('id', '[0-9]+');

//    $router->get('sign/{vue_capture?}', 'SignSystemController@index')
//        ->where('vue_capture', '[\/\w\.-]*');
});

//if ($app->isLocal()) {
//    Route::get('event', function () {
//
//        $parameters = [
//            'unique_id' => request()->session()->getId(),
//            'department' => '移动组',
//            'number' => 1,
//        ];
//        $group = new \App\Group();
//        $group->unique_id = $parameters['unique_id'];
//        $group->department = $parameters['department'];
//        $group->number = $parameters['number'];
//
//        \App\Group::where('department', $parameters['department'])
//            ->where('number', $parameters['number'])
//            ->update(['unique_id' => $parameters['unique_id']]);
//
//        $group = \App\Group::where('department', $parameters['department'])
//            ->where('number', $parameters['number'])->first();
//
//        event(new \App\Events\InterviewerLoginEvent($group));
//        return 'event fire';
//    });
//}