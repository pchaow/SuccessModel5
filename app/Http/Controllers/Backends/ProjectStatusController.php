<?php

namespace App\Http\Controllers\Backends;

use App\Models\Faculty;
use App\Models\ProjectStatus;
use App\Models\Role;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Request;

class ProjectStatusController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $statuses = ProjectStatus::all();
        return view('backends.project-status-index')
            ->with('statuses', $statuses);
    }


}
