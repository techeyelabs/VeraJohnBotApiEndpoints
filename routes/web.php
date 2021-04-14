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
    Route::get('bethistory/{id}', 'BetController@userbethistory')->name('bethistory');
    Route::get('withdrawhistory/{id}', 'BetController@withdrawhistory')->name('withdrawhistory');
    Route::get('deposithistory/{id}', 'BetController@deposithistory')->name('deposithistory');
    Route::get('creategroup', 'ClientcreateController@creategroup')->name('creategroup');
    Route::post('create-group-action', 'ClientcreateController@creategroupaction')->name('create-group-action');
    Route::get('personal_settings', 'ClientcreateController@personal_settings')->name('personal_settings');
    Route::get('personal_list/{id}', 'ClientcreateController@personal_list')->name('personal_list');
    Route::get('nogroup_users', 'ClientcreateController@nogroup_users')->name('nogroup_users');
    Route::post('personal_settings_action', 'ClientcreateController@personal_settings_action')->name('personal_settings_action');
    Route::get('edit_group/{id}', 'ClientcreateController@edit_group')->name('edit_group');
    Route::post('edit_group_action/{id}', 'ClientcreateController@edit_group_action')->name('edit_group_action');
    Route::get('delete_group/{id}', 'ClientcreateController@delete_group')->name('delete_group');
    Route::get('installerdownload', 'ClientcreateController@download')->name('filedownload');
    
});
Route::post('post-register', 'AuthController@postRegister')->name('post-register'); 
Route::get('register', 'AuthController@register')->name('register');
Route::get('logout', 'AuthController@logout')->name('logout');

Route::post('post-login', 'AuthController@postLogin')->name('post-login'); 


//Dummy Routes
Route::get('startrelation', 'dummyController@startrelation')->name('startrelation');
