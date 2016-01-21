<?php

namespace App\Http\Controllers\Frontends;

use App\Services\ProjectService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Glide\Server;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends BaseController
{

    public function getCover(Server $server, Request $request, $projectId, $file)
    {
        return ProjectService::getCover($server, $request, $projectId, $file);
    }

}
