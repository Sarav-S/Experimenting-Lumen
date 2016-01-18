<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return view('index');
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('users/', 'App\Http\Controllers\UserController@index');

    $api->post('users/', ['uses' => 'App\Http\Controllers\UserController@create', 'as' => 'user-create']);

    $api->get('users/{id}', 'App\Http\Controllers\UserController@show');
    
    $api->put('users/{id}', 'App\Http\Controllers\UserController@update');

    $api->delete('users/{id}', 'App\Http\Controllers\UserController@delete');
});
