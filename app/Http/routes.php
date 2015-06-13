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


/API路由
//Route::group(['prefix'=>'api/v1'],function(){
//    Route::resource('users','UsersController');
//});
$api = app('api.router');
$api->version('v1',
    [
        'prefix'    => 'api',
        'namespace' => 'App\Http\Controllers',
        'protected' => true
    ], function ($api) {
        $api->resource('users', 'UsersController');
        $api->resource('app', 'WelcomeController');
        $api->post('oauth/access_token', function () {
            return Response::json(Authorizer::issueAccessToken());
        });
    });
