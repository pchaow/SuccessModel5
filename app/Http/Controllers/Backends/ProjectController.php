<?php

namespace App\Http\Controllers\Backends;

use App\Models\Faculty;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Role;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $user = Auth::user();
        $projects = $user->projects;
        return view("backends.researchers.project-index")
            ->with("projects", $projects);
    }

    public function addForm(Request $request)
    {
        $project = new Project();
        return view("backends.researchers.project-addform")
            ->with('project', $project);
    }

    public function doAdd(Request $request)
    {

    }

    public function editForm(Request $request)
    {

    }

    public function doEdit(Request $request)
    {

    }

    public function doDelete(Request $request)
    {

    }

}
