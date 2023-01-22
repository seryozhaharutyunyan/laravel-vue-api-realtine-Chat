<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'namespace'=>'App\Http\Controllers\Auth', 'prefix' => 'auth'], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
Route::group(['middleware' => 'jwt.auth', 'namespace'=>'App\Http\Controllers\Admin', 'prefix' => 'admin'], function () {

    Route::group(['prefix'=>'countries'], function (){
        Route::get('/', 'CountryController@index');
        Route::post('/', 'CountryController@store');
        Route::post('/{country}', 'CountryController@update');
        Route::delete('/{country}', 'CountryController@destroy');
    });

    Route::group(['prefix'=>'roles'], function (){
        Route::get('/', 'RoleController@index');
        Route::post('/', 'RoleController@store');
        Route::post('/{role}', 'RoleController@update');
        Route::delete('/{role}', 'RoleController@destroy');
    });

    Route::group(['prefix'=>'edges'], function (){
        Route::get('/', 'EdgeController@index');
        Route::post('/', 'EdgeController@store');
        Route::post('/{edge}', 'EdgeController@update');
        Route::delete('/{edge}', 'EdgeController@destroy');
    });

    Route::group(['prefix'=>'chats'], function (){
        Route::get('/', 'ChatController@index');
        Route::get('/{edge}', 'ChatController@show');
        Route::post('/', 'ChatController@store');
        Route::post('/{chat}', 'ChatController@update');
        Route::delete('/{chat}', 'ChatController@destroy');
    });

    Route::group(['prefix'=>'users'], function (){
        Route::get('/', 'UserController@index');
        Route::get('/block/{user}', 'UserController@block');
        Route::post('/role/{user}', 'UserController@role');
        Route::post('/search', 'UserController@search');
        Route::delete('/{user}', 'UserController@destroy');
    });
});

Route::group(['namespace'=>'App\Http\Controllers', 'middleware' => 'jwt.auth'], function (){
    Route::get('/edges/{country}', 'BaseController@getEdges');
    Route::get('/users/{country}', 'BaseController@getUsers');
    Route::post('/account', 'AccountController@update');
});

Route::group(['namespace'=>'App\Http\Controllers\Registration', 'prefix' => 'registration'], function () {

    Route::get('/', 'RegistrationController@index');
    Route::post('/', 'RegistrationController@store');
    Route::post('/reset', 'RegistrationController@reset');

});

Route::group(['namespace'=>'App\Http\Controllers\Basic', 'prefix' => 'basic'], function () {

    Route::get('/{country}', 'HomeController@index');
    Route::get('/show/{edge}', 'HomeController@show');

    Route::get('/chat/{chat}', 'ChatController@index');
    Route::post('/chat', 'ChatController@store');

});
