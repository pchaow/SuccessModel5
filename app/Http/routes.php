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

    Route::get('/', "FrontendController@index");


});

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::get('/researcher/dropdown/{keyword?}', "Backends\\UserController@apiGetResearcherForDropdown");

    Route::get("/province", function () {
        return \App\Models\Thailand\Province::all();
    });

    Route::get("/province/{provinceId}/amphur", function ($provinceId) {
        return \App\Models\Thailand\Amphur::where("PROVINCE_ID", "=", $provinceId)->get();
    });

    Route::get("/province/{provinceId}/amphur/{amphurId}/district", function ($provinceId, $amphurId) {
        return \App\Models\Thailand\District::where("PROVINCE_ID", "=", $provinceId)
            ->where("AMPHUR_ID", "=", "$amphurId")->get();
    });

});

Route::group(['prefix' => 'project', 'middleware' => ['web']], function () {

    //project
    Route::get('{projectId}/cover/{filename?}', "Frontends\\ProjectController@getCover");
});


Route::group(['prefix' => 'backend', 'middleware' => ['web']], function () {

    //login
    Route::get('login', "BackendController@login");
    Route::get('logout', "BackendController@logout");
    Route::post('doLogin', "BackendController@doLogin");

    Route::group(['middleware' => 'auth'], function () {
        //Dashboard
        Route::get('/', 'BackendController@index');
    });

    Route::group(['middleware' => ['auth', 'researcher']], function () {
        Route::get('projects', "Backends\\ProjectController@index");
    });


    //faculty
    Route::get('/faculty/', 'Backends\\FacultyController@index');
    Route::get('/faculty/addForm', 'Backends\\FacultyController@addForm');
    Route::post('/faculty/doAdd', 'Backends\\FacultyController@doAdd');
    Route::get('/faculty/{id}/edit', 'Backends\\FacultyController@editForm');
    Route::post('/faculty/{id}/doEdit', 'Backends\\FacultyController@doEdit');
    Route::post('/faculty/{id}/delete', 'Backends\\FacultyController@doDelete');

    //role
    Route::get('role', 'Backends\\RoleController@index');

    //project status
    Route::get('project-status', 'Backends\\ProjectStatusController@index');

    //admin project
    Route::get('admin/project', "Backends\\AdminProjectController@index");
    Route::get('admin/project/addForm', 'Backends\\AdminProjectController@addForm');
    Route::post('admin/project/doAdd', 'Backends\\AdminProjectController@doAdd');
    Route::get('admin/project/{id}/edit/{step?}', 'Backends\\AdminProjectController@editForm');
    Route::post('admin/project/{id}/doEdit', 'Backends\\AdminProjectController@doEdit');
    Route::post('admin/project/{id}/delete', 'Backends\\AdminProjectController@doDelete');
    //admin project cover
    Route::get('admin/project/{id}/getCover/{filename?}', 'Backends\\AdminProjectController@getCover');
    Route::post('admin/project/{id}/doSaveCover', 'Backends\\AdminProjectController@doSaveCover');
    //admin project photo
    Route::get('admin/project/{id}/photos/{file}', "Backends\\AdminProjectController@getPhoto");
    Route::post('admin/project/{id}/doUploadPhoto', "Backends\\AdminProjectController@doUploadPhoto");
    Route::post('admin/project/{projectId}/photo/{photoId}/delete', "Backends\\AdminProjectController@doDeletePhoto");
    Route::post('admin/project/{projectId}/photo/{photoId}/doEditPhoto', "Backends\\AdminProjectController@doEditPhoto");

    //admin project youtube
    Route::post("admin/project/{projectId}/doAddYoutube", "Backends\\AdminProjectController@doAddYoutube");
    Route::post('admin/project/{projectId}/youtube/{youtubeId}/delete', "Backends\\AdminProjectController@doDeleteYoutube");

    //admin project google map
    Route::post("admin/project/{projectId}/doSaveMap", "Backends\\AdminProjectController@doSaveMap");

    //admin project user
    Route::post("admin/project/{projectId}/doAddUser", "Backends\\AdminProjectController@doAddUser");
    Route::post("admin/project/{projectId}/user/{userId}/delete", "Backends\\AdminProjectController@doDeleteUser");

    //user

    Route::get("user", "Backends\\UserController@index");
    Route::get('user/addForm', 'Backends\\UserController@addForm');
    Route::post('user/doAdd', 'Backends\\UserController@doAdd');
    Route::get('user/{id}/edit', 'Backends\\UserController@editForm');
    Route::post('user/{id}/doEdit', 'Backends\\UserController@doEdit');
    Route::post('user/{id}/delete', 'Backends\\UserController@doDelete');

});