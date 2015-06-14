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

Route::get('/', function () {
    return view('welcome');
});
Route::get('errors/404', function(){
    return view('errors/404');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    'demo' => 'WelcomeController',
]);


//API路由
$api = app('api.router');
$api->version('v1',
    [
        'prefix'    => 'api',                   //路由前缀
        'namespace' => 'App\Http\Controllers',  //API命名空间
        'protected' => true,                    //是否需要登录认证
        'limit'     => 30,                      //请求速率
        'expires'   => 1                        //请求限制时间限制
    ], function ($api) {
        //获取access_token路由，不需要登录认证
        $api->get('oauth/access_token', ['protected'=> false,function () {
            return Authorizer::issueAccessToken();
        }]);
        $api->resource('users', 'UsersController');
        $api->resource('app', 'WelcomeController');

    });
$api->version('v2',
    [
        'prefix'    => 'api',                   //路由前缀
        'namespace' => 'App\Http\Controllers',  //API命名空间
        'protected' => true,                    //是否需要登录认证
        'limit'     => 30,                      //请求速率
        'expires'   => 1                        //请求限制时间限制
    ], function ($api) {
        //获取access_token路由，不需要登录认证
        $api->get('oauth/access_token', ['protected'=> false,function () {
            return Authorizer::issueAccessToken();
        }]);
        $api->resource('users', 'UsersController');
        $api->resource('app', 'WelcomeController');

    });
