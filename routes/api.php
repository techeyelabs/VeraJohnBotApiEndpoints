<?php

use Illuminate\Http\Request;
use  App\Http\Controllers;

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

Route::get('clients', 'ApiController@getAllClient');

Route::get('client/{id}', 'ApiController@getClient');
Route::post('client', 'ApiController@createClient');
Route::put('client/{id}', 'ApiController@updateClient');
Route::delete('client/{id}','ApiController@deleteClient');


// Third party Api's
Route::get('userauthentication', 'ApiController@userauthentication');
Route::get('betstartlog', 'ApiController@betstartlog');
Route::get('betendlog', 'ApiController@betendlog');