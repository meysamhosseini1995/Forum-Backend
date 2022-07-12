<?php

use Illuminate\Support\Facades\Route;

$api_namespace = 'App\Http\Controllers\API';
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['namespace' => $api_namespace], function () {

    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {

        // Authentication Routes
        Route::group(['prefix' => 'auth/'], function () {
            Route::get('user', 'AuthController@user')->name("auth.user");
            Route::post('login', 'AuthController@login')->name("auth.login");
            Route::post('logout', 'AuthController@logout')->name("auth.logout");
            Route::post('register', 'AuthController@register')->name("auth.register");
        });

        // Channel Routes
        Route::group(['prefix' => 'channel/'], function () {
            Route::get('all', 'ChannelController@getAllChannelsList')->name("channels.all");
            Route::post('create', 'ChannelController@createNewChannel')->name("channels.create");
            Route::put('update', 'ChannelController@updateChannel')->name("channels.update");
            Route::delete('delete', 'ChannelController@deleteChannel')->name("channels.delete");
        });
    });

});