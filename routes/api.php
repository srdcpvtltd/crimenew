<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'namespace' => 'Api',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('unauthorized', 'AuthController@unauthorized')->name('unauthorized');
    Route::post('me', 'AuthController@me');
    Route::post('register','AuthController@register')->name('register');

    Route::post('criminal','CrimeController@criminal')->name('criminal');
    Route::get('criminal-list','CrimeController@criminalList')->name('criminal-list');
    Route::post('search-with-station-and-mo-type', 'CrimeController@station_and_mo_type');
});

