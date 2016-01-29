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
        $project_input = $request->get('project');

        $project = new Project();
        $project->fill($project_input);

        if ($project_input['faculty']['id'] != "") {
            $project->faculty()->associate(Faculty::find($project_input['faculty']['id']));
        }

        if ($project_input['status']['id'] != "") {
            $project->status()->associate(ProjectStatus::find($project_input['status']['id']));
        } else {
            $project->status()->associate(ProjectStatus::where('key', '=', 'draft')->first());
        }

        $project->save();

        if ($user = Auth::user()) {
            $project->createBy()->associate($user)->save();
        }


        return redirect('/backend/project');
    }

    public function editForm(Request $request, $id, $step = "first")
    {
        $project = Project::find($id);
        if ($project) {
            return view("backends.researchers.project-editform")
                ->with('project', $project)
                ->with('step', $step);
        } else {
            return redirect('backend/project');
        }
    }


    public function doEdit(Request $request, $id)
    {
        $project_input = $request->get('project');

        $project = Project::find($id);
        if (!$project) {
            return redirect('backend/admin/project');
        }
        $project->fill($project_input);
        $project->faculty()->associate(Faculty::find($project_input['faculty']['id']));
        if ($project_input['status']['id'] != "") {
            $project->status()->associate(ProjectStatus::find($project_input['status']['id']));
        } else {
            $project->status()->associate(ProjectStatus::where('key', '=', 'draft')->first());
        }
        $project->save();

        return redirect('/backend/project');
    }

    public function doDelete(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return redirect('backend/admin/project');
        }

        $project->delete();

        return redirect('/backend/project');
    }

    public function doSubmit(Request $request, $id)
    {
        /* @var Project $project */
        $project = Project::find($id);

        if (!$project) {
            return redirect('backend/admin/project');
        }

        if ($project) {
            $status = ProjectStatus::where('key', '=', 'faculty')->first();
            $project->status()->associate($status)->save();
        }


        return redirect('/backend/project');
    }


    public function previewProject(Request $request, $id, $role)
    {
        $project = Project::find($id);

        return view('backends.project.preview')
            ->with('project', $project)
            ->with('previewRole', $role);

    }


}
