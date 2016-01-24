<?php

namespace App\Http\Controllers;

use App\Http\Soaps\LoginSoap;
use App\Http\Soaps\UserInfoSoap;
use App\Models\Faculty;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $projects = \App\Models\Project::whereHas('status', function ($q) {
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
