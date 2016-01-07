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

    //login
    Route::get('login',"BackendController@login");
    Route::post('doLogin',"BackendController@doLogin");

    //Dashboard
    Route::get('/','BackendController@index');

    //faculty
    Route::get('/faculty/','Backends\\FacultyController@index');

    Route::get('/faculty/addForm','Backends\\FacultyController@addForm');
    Route::post('/faculty/doAdd','Backends\\FacultyController@doAdd');

    Route::get('/faculty/{id}/edit','Backends\\FacultyController@editForm');
    Route::post('/faculty/{id}/doEdit','Backends\\FacultyController@doEdit');

    Route::post('/faculty/{id}/delete','Backends\\FacultyController@doDelete');

    //role
    Route::get('role','Backends\\RoleController@index');

    //project status
    Route::get('project-status','Backends\\ProjectStatusController@index');

    //admin project
    Route::get('admin/project',"Backends\\AdminProjectController@index");

    Route::get('admin/project/addForm','Backends\\AdminProjectController@addForm');
    Route::post('admin/project/doAdd','Backends\\AdminProjectController@doAdd');

    Route::get('admin/project/{id}/edit','Backends\\AdminProjectController@editForm');
    Route::post('admin/project/{id}/doEdit','Backends\\AdminProjectController@doEdit');

    Route::post('admin/project/{id}/delete','Backends\\AdminProjectController@doDelete');

});