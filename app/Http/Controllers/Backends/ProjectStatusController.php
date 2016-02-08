<?php

namespace App\Http\Controllers\Backends;


use App\Models\Project\ProjectStatus;
use Illuminate\Routing\Controller as BaseController;

class ProjectStatusController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $statuses = ProjectStatus::all();
        return view('backends.admins.project-status-index')
            ->with('statuses', $statuses);
    }

}
