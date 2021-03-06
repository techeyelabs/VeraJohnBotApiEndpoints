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
Route::get('userauthentication', 'ApiController@userauthentication');  // Authenticate user into web system
Route::get('verajohnIdPass-Registration', 'ApiController@verajohnIdPassRegistration');  // Put verajohn id pass into web system
Route::get('betstartlog', 'BetController@betstartlog');
Route::get('betendlog', 'BetController@betendlog');

Route::get('bethistory', 'BetController@bethistory');  // get last bet data. such as how much was placed as bet
Route::get('betwinning', 'BetController@bethistory');  // get last winning data

Route::get('account', 'ApiController@account');
Route::get('beteligibility', 'ApiController@beteligibility');

Route::get('devicevalidation', 'ApiController@devicevalidation');  // check if the device is known
Route::get('accountIdPassValidation', 'ApiController@devicevalidation');  // check if the device is known
Route::get('deviceReg', 'ApiController@deviceReg');  // Register the device
Route::get('deposit-withdraw-history', 'ApiController@depowithreg');  // create log for user deposit and withdraw history
Route::get('get-last-deposit-withdraw-history', 'ApiController@getlastdepowithreg');  // create log for user deposit and withdraw history
Route::get('lock-user-until-next', 'ApiController@lockUserUntilNext');  // create log for user deposit and withdraw history
