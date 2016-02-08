<?php

namespace App\Http\Controllers;

use App\Models\Project\Project;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $projects = Project::whereHas('status', function ($q) {
            $q->where('key', '=', 'published');
        })->get();
        return view('frontends.index')
            ->with('projects', $projects);
    }

    public function project(Request $request, $projectId)
    {

        $project = Project::find($projectId);

        return view('frontends.project')
            ->with('project', $project);

    }

}
