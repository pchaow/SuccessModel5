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

use App\Models\Project\Project;
use \App\Models\Thailand\Province;
use Illuminate\Support\Collection;

Route::get('map-data/{id}', function ($provinceId) {
    $query = \App\Models\Thailand\Amphur::query();

    $query->select([
        'amphur.amphur_id',
        'amphur.amphur_name',
        DB::raw(" count(projects.id) as numProAmp "),
        "sub.faculty_id",
        "sub.faculty_name",
        "sub.numProFacAmp"

    ]);

    $query->leftJoin('projects', function($join){
        $join->on('projects.amphur_id', '=', 'amphur.amphur_id');
        $join->on('projects.status_id', '=', DB::raw("4"));
    });
    $query->leftJoin('faculties', 'projects.faculty_id', '=', 'faculties.id');

    $query->leftJoin(
        DB::raw(
            "
                (
                    select
                        count(projects.id) as numProFacAmp
                        , projects.amphur_id
                        , projects.faculty_id
                        ,faculties.name_th as faculty_name
                    from projects
                    left join faculties on projects.faculty_id = faculties.id
                    where projects.province_id = $provinceId
                    group by projects.faculty_id , projects.amphur_id
                ) as sub

            "
        ),
        function ($join) {
            $join->on('sub.amphur_id', '=', 'amphur.amphur_id');
        }
    );

    $query->where('amphur.province_id', '=', "$provinceId");

    $query->groupBy('amphur.amphur_id');
    $query->groupBy('sub.faculty_id');

    $query->orderBy('numProAmp', 'desc');

    $query = $query->get()->toArray();

    $result = [];
    foreach ($query as $item) {
        $amphur_name = $item["amphur_name"];
        if (!array_key_exists($amphur_name, $result)) {
            $result[$amphur_name] = [];
        }
        //$result[$amphur_name][] = $item;
        $result[$amphur_name]["name"] = $amphur_name;
        $result[$amphur_name]["amphur_id"] = $item["amphur_id"];
        $result[$amphur_name]["value"] = $item["numProAmp"];
        if ($item["faculty_id"]) {
            $result[$amphur_name]["faculties"][] = $item;
        }

    }

    $arrayRes = [];

    foreach ($result as $key => $value) {
        if(!array_key_exists("faculties",$value)){
            $value['faculties'] = [];
        }
        $arrayRes[] = $value;
    }
    $query = $arrayRes;

    return $query;
});

Route::group(['prefix' => 'm1', 'middleware' => ['api']], function () {

    Route::group(['middleware' => ['cors']], function () {
        Route::get('faculty', function () {
            return \App\Models\Faculty::all();
        });

        Route::get('faculty/{id}/project', function ($id) {
            $projects = Project::whereHas('faculty', function ($q) use ($id) {
                $q->where('id', '=', $id);
            })->with(['faculty'])
                ->orderBy('created_at', 'desc')
                ->get();
            return $projects;
        });

        Route::get('project', function () {
            return Project::with(['faculty'])
                ->whereHas('status', function ($q) {
                    $q->where('key', '=', 'published');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        });

        Route::get('project/search', function (\Symfony\Component\HttpFoundation\Request $request) {
            $faculty_id = $request->get('faculty_id');
            $keyword = $request->get('keyword');

            $query = Project::query();

            if ($faculty_id) {
                $query = $query->where('faculty_id', '=', $faculty_id);

            }
            if ($keyword) {
                $query = $query->where('name_th', 'LIKE', "%$keyword%");
                $query = $query->orWhere('name_en', 'LIKE', "%$keyword%");
            }
            $query->whereHas('status', function ($q) {
                $q->where('key', '=', 'published');
            });
            $projects = $query->get();

            return $projects;

        });

        Route::get('project/{id}', function ($id) {
            $project = Project::with(['faculty', 'photos', 'youtubes', 'users', 'province', 'amphur', 'district'])->where('id', '=', $id)->first();
            return $project;
        });


    });


    Route::get('project/{id}/photos/{file}', "Frontends\\ProjectController@getPhoto");
    Route::get('project/{projectId}/cover/{filename?}', "Frontends\\ProjectController@getCover");


    Route::group(['prefix' => 'post'], function () {

        Route::group(['middleware' => ['cors']], function () {
            Route::get('/', "Backends\\PostController@listPost");
            Route::get('/{id}', "Backends\\PostController@getPost");
            Route::post('/{id}/doUploadPhoto', "Backends\\PostController@doUploadPhoto");
            Route::post('/{id}/photo/{photoId}/delete', "Backends\\PostController@doDeletePhoto");
            Route::post('/{id}/photo/{photoId}/doEditPhoto', "Backends\\PostController@doEditPhoto");
        });

        Route::get('/{id}/cover/{filename?}', 'Backends\\PostController@getCover');
        Route::get('/{id}/photos/{file}', "Backends\\PostController@getPhoto");
    });

});

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    Route::get('project', function () {
        $projects = Project::whereHas('status', function ($q) {
            $q->where('key', '=', 'published');
        })->get();
        return $projects;
    });

    Route::get('project/{id}', function ($id) {
        $project = Project::with(['photos', 'youtubes', 'users'])->find($id);

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


Route::group(['middleware' => ['web']], function () {

    Route::get('/', "FrontendController@index");

    Route::get('/post/{id}', "FrontendController@getPost");

});

Route::group(['prefix' => 'project', 'middleware' => ['web']], function () {

    //project
    Route::get('/', function (\Symfony\Component\HttpFoundation\Request $request) {
        $faculty_id = $request->get('faculty_id');
        $keyword = $request->get('keyword');
        $query = Project::query();

        if ($faculty_id) {
            $query = $query->where('faculty_id', '=', $faculty_id);

        }
        if ($keyword) {
            $query = $query->where('name_th', 'LIKE', "%$keyword%");
            $query = $query->orWhere('name_en', 'LIKE', "%$keyword%");
        }

        $projects = $query->get();

        return view('frontends.search')
            ->with('projects', $projects);

    });
    Route::get('{id}', "FrontendController@project");
    Route::get('{projectId}/cover/{filename?}', "Frontends\\ProjectController@getCover");
    Route::get('{id}/photos/{file}', "Frontends\\ProjectController@getPhoto");

});


Route::group(['prefix' => 'post', 'middleware' => ['web']], function () {

    Route::get('/{id}/cover/{filename?}', 'Backends\\PostController@getCover');
    Route::get('/{id}/photos/{file}', "Backends\\PostController@getPhoto");
    Route::post('/{id}/doUploadPhoto', "Backends\\PostController@doUploadPhoto");
    Route::post('/{id}/photo/{photoId}/delete', "Backends\\PostController@doDeletePhoto");
    Route::post('/{id}/photo/{photoId}/doEditPhoto', "Backends\\PostController@doEditPhoto");

});


Route::group(['prefix' => 'backend', 'middleware' => ['web']], function () {

    //login
    Route::get('login', "BackendController@login");
    Route::get('logout', "BackendController@logout");
    Route::get('profile', "Backends\\UserController@changeProfile");
    Route::post('profile', "Backends\\UserController@doChangeProfile");
    Route::post('doLogin', "BackendController@doLogin");

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['prefix' => 'post'], function () {

            Route::get('/', "Backends\\PostController@index");
            Route::get('addForm', "Backends\\PostController@addForm");
            Route::post('doAdd', "Backends\\PostController@doAdd");

            Route::get('/{id}/edit/{step?}', "Backends\\PostController@editForm");
            Route::post('/{id}/doEdit', "Backends\\PostController@doEdit");

            Route::post('/{id}/submit', "Backends\\PostController@doSubmit");

            Route::get('/{id}/getCover/{filename?}', 'Backends\\PostController@getCover');
            Route::post('/{id}/doSaveCover', "Backends\\PostController@doSaveCover");

            Route::post('/{id}/delete', "Backends\\PostController@doDelete");

            Route::get('/{id}/preview', "Backends\\PostController@preview");

            Route::get('/{id}/photos/{file}', "Backends\\PostController@getPhoto");
            Route::post('/{id}/doUploadPhoto', "Backends\\PostController@doUploadPhoto");
            Route::post('/{id}/photo/{photoId}/delete', "Backends\\PostController@doDeletePhoto");
            Route::post('/{id}/photo/{photoId}/doEditPhoto', "Backends\\PostController@doEditPhoto");

        });

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
            Route::get('admin/project/{id}/doGenerateImageCache', 'Backends\\AdminProjectController@doGenerateImageCache');

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