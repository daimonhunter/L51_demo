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
Route::api('v1', function () {
    Route::get('users/{id}', 'Api\V1\UserController@show');
});

Route::api('v2', function () {
    Route::get('users/{id}', 'Api\V2\UserController@show');
});
