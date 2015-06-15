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
Log::info(var_export(Request::url(),true));
Log::info(var_export($_REQUEST,true));
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
        //oauth2.0 登录页面,登录成功后返回客户端接收authorization_code地址
        $api->get('oauth2/authorize', ['protected'=> false,function () {
            //未完成
            return Authorizer::issueAuthCode(
                    'client',
                    Request::input('client_id'),
                    [
                        'redirect_uri'  => Request::input('redirect_uri'),
                        'client'        => Request::input('client_id'),
                        'scopes'        => Request::input('scopes'),
                        'state'         => Request::input('state'),
                    ]);
        }]);
        //发放authorization_code
        $api->post('oauth2/authorize', 'AuthController@getAuthorizeCode');
        //获取access_token路由，不需要登录认证
        $api->get('oauth2/access_token', ['protected'=> false,function () {
            try{
                Log::info(var_export($_GET,true));
                $token = Authorizer::issueAccessToken();
            }catch (Exception $e){
                Log::info(var_export($e->getMessage(),true));
            }
            Log::info(var_export($token,true));

            return $token;
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
