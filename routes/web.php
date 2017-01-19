<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {
    Route::post('backups/{fileName}/restore', ['as'=>'backups.restore', 'uses'=>'BackupsController@restore']);
    Route::get('backups/{fileName}/dl', ['as'=>'backups.download', 'uses'=>'BackupsController@download']);
    Route::resource('backups','BackupsController');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
