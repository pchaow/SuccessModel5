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

    Route::get('project', function () {
        $projects = \App\Models\Project::whereHas('status', function ($q) {
            $q->where('key', '=', 'published');
        })->get();
        return $projects;
    });

    Route::get('project/{id}', function ($id) {
        $project = \App\Models\Project::with(['photos', 'youtubes', 'users'])->find($id);

        return $project;
    });

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
    Route::get('{id}', "FrontendController@project");
    Route::get('{projectId}/cover/{filename?}', "Frontends\\ProjectController@getCover");
    Route::get('{id}/photos/{file}', "Frontends\\ProjectController@getPhoto");

});


Route::group(['prefix' => 'backend', 'middleware' => ['web']], function () {

    //login
    Route::get('login', "BackendController@login");
    Route::get('logout', "BackendController@logout");
    Route::post('doLogin', "BackendController@doLogin");

    Route::group(['middleware' => 'auth'], function () {
        //Dashboard
        Route::get('/', 'BackendController@index');

        Route::get('preview/project/{id}/{role}', "Backends\\ProjectController@previewProject");

        Route::group(['middleware' => ['researcher']], function () {
            Route::get('project', "Backends\\ProjectController@index");
            Route::get('project/addForm', 'Backends\\ProjectController@addForm');
            Route::get('project/{projectId}/edit', 'Backends\\ProjectController@editForm');
            Route::post('project/doAdd', 'Backends\\ProjectController@doAdd');
            Route::post('project/{id}/doEdit', 'Backends\\ProjectController@doEdit');
            Route::post('project/{id}/delete', 'Backends\\ProjectController@doDelete');

            Route::post('researcher-project/{id}/doAccept', 'Backends\\ProjectController@doSubmit');

        });

        Route::group(['middleware' => ['faculty']], function () {
            Route::get('faculty-project', "Backends\\FacultyProjectController@index");

            //ajax
            Route::post('faculty-project/{id}/doAccept', "Backends\\FacultyProjectController@doAccept");
            Route::post('faculty-project/{id}/doReject', "Backends\\FacultyProjectController@doReject");

        });

        Route::group(['middleware' => ['university']], function () {
            Route::get('university-project', "Backends\\UniversityProjectController@index");

            //ajax
            Route::post('university-project/{id}/doAccept', "Backends\\UniversityProjectController@doAccept");
            Route::post('university-project/{id}/doReject', "Backends\\UniversityProjectController@doReject");

        });


        Route::group(['middleware' => ['admin']], function () {

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
    });

});