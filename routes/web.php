<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'AuthController@loginHome')->name('login');
Route::group(['middleware' => 'admin-auth'], function () {
    Route::get('/', 'AuthController@dashboard')->name('dashboard'); 
    Route::get('create-user', 'ClientcreateController@createuser')->name('create-user');
    Route::post('create-user-action', 'ClientcreateController@createuseraction')->name('create-user-action');
    Route::get('user-list', 'ClientcreateController@userlist')->name('user-list');
    Route::get('user-details/{id}', 'ClientcreateController@userdetails')->name('user-details');
    Route::get('change-user-status', 'ClientcreateController@changeuserstatus')->name('change-user-status');
    Route::get('details/{id}', 'ClientcreateController@details')->name('details');
    Route::get('automatebet', 'ClientcreateController@automatebet')->name('automatebet');
    
});
Route::post('post-register', 'AuthController@postRegister')->name('post-register'); 
Route::get('register', 'AuthController@register')->name('register');
Route::get('logout', 'AuthController@logout')->name('logout');

Route::post('post-login', 'AuthController@postLogin')->name('post-login'); 


//Dummy Routes
Route::get('startrelation', 'dummyController@startrelation')->name('startrelation');
