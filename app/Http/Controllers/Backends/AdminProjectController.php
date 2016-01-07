<?php

namespace App\Http\Controllers\Backends;

use App\Models\Faculty;
use App\Models\Project;
use App\Models\ProjectStatus;
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

        $projects = Project::with('faculty')->get();
        return view("backends.admins.project-index")
            ->with("projects", $projects);
    }

    public function addForm(Request $request)
    {
        $project = new Project();
        return view("backends.admins.project-addform")
            ->with('project', $project);
    }

    public function doAdd(Request $request)
    {

        $project_input = $request->get('project');

        $project = new Project();
        $project->fill($project_input);
        $project->faculty()->associate(Faculty::find($project_input['faculty']['id']));
        $project->status()->associate(ProjectStatus::where('key', '=', 'draft')->first());
        $project->save();

        return redirect('/backend/admin/project');

    }

    public function editForm(Request $request, $id)
    {
        $project = Project::find($id);
        return view("backends.admins.project-editform")
            ->with('project', $project);
    }

    public function doEdit(Request $request,$id)
    {
        $project_input = $request->get('project');

        $project = Project::find($id);
        $project->fill($project_input);
        $project->faculty()->associate(Faculty::find($project_input['faculty']['id']));
        //$project->status()->associate(ProjectStatus::where('key', '=', 'draft')->first());
        $project->save();

        return redirect('/backend/admin/project');
    }

    public function doDelete(Request $request,$id)
    {
        Project::find($id)->delete();
        return redirect('/backend/admin/project');
    }

}
