<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});


Route::group(['prefix'=>'backend'],function(){
    Route::get('/','BackendController@index');

    Route::get('/faculty/','Backends\\FacultyController@index');

    Route::get('/faculty/addForm','Backends\\FacultyController@addForm');
    Route::post('/faculty/doAdd','Backends\\FacultyController@doAdd');

    Route::get('/faculty/{id}/edit','Backends\\FacultyController@editForm');
    Route::post('/faculty/{id}/doEdit','Backends\\FacultyController@doEdit');

    Route::post('/faculty/{id}/delete','Backends\\FacultyController@doDelete');

});