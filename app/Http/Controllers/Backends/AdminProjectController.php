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

class AdminProjectController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view("backends.admins.admin-project-index");
    }

    public function addForm(Request $request)
    {

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
