<?php

namespace App\Http\Controllers\Backends;

use App\Models\Faculty;
use App\Models\Photo;
use App\Models\Project;
use App\Models\ProjectStatus;
use Faker\Provider\Uuid;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Glide\Server;
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

        if ($project_input['status']['id'] != "") {
            $project->status()->associate(ProjectStatus::find($project_input['status']['id']));
        } else {
            $project->status()->associate(ProjectStatus::where('key', '=', 'draft')->first());
        }

        $project->save();

        return redirect('/backend/admin/project');

    }

    public function editForm(Request $request, $id, $step = "first")
    {
        $project = Project::find($id);
        return view("backends.admins.project-editform")
            ->with('project', $project)
            ->with('step', $step);
    }

    public function doEdit(Request $request, $id)
    {
        $project_input = $request->get('project');

        $project = Project::find($id);
        $project->fill($project_input);
        $project->faculty()->associate(Faculty::find($project_input['faculty']['id']));
        if ($project_input['status']['id'] != "") {
            $project->status()->associate(ProjectStatus::find($project_input['status']['id']));
        } else {
            $project->status()->associate(ProjectStatus::where('key', '=', 'draft')->first());
        }
        $project->save();

        return redirect('/backend/admin/project');
    }

    public function doDelete(Request $request, $id)
    {
        Project::find($id)->delete();
        return redirect('/backend/admin/project');
    }

    public function doSaveCover(Request $request, $id)
    {
        $file = $request->files->get("project")["cover_upload"];
        if ($file->isValid()) {

            $originalExt = $file->getClientOriginalExtension();
            $newFileName = Uuid::uuid() . "." . $originalExt;
            $destinationPath = storage_path("app/project/$id/cover");
            $file->move($destinationPath, $newFileName);

            $project = Project::find($id);

            $project->cover_file = $newFileName;
            $project->save();

        }

        return redirect("/backend/admin/project/$id/edit/second");
    }

    public function getCover(Server $server, Request $request, $id, $file)
    {
        //$project = Project::find($id);
        $cover_file = $file;

        $path = "project/$id/cover/$cover_file";

        return $server->outputImage($path, $_GET);
    }

    public function doUploadPhoto(Request $request, $id)
    {
        $file = $request->files->get("photo")["file"];
        $photoInput = $request->get('photo');
        if ($file->isValid()) {

            $originalExt = $file->getClientOriginalExtension();
            $newFileName = Uuid::uuid() . "." . $originalExt;
            $destinationPath = storage_path("app/project/$id/photo");
            $file->move($destinationPath, $newFileName);

            $photo = new Photo();
            $photo->description = $photoInput['description'];
            $photo->filename = $newFileName;

            /* @var Project $project */
            $project = Project::find($id);
            $project->photos()->save($photo);

        }

        return redirect("/backend/admin/project/$id/edit/third");
    }

    public function getPhoto(Server $server, Request $request, $id, $file)
    {
        $photo_file = $file;

        $path = "project/$id/photo/$photo_file";

        return $server->outputImage($path, $_GET);
    }

    public function doDeletePhoto(Request $request, $projectId, $photoId)
    {
        /* @var Photo $photo */
        $photo = Photo::find($photoId);
        $photo->delete();

        return redirect("/backend/admin/project/$projectId/edit/third");

    }

    public function doEditPhoto(Request $request, $projectId, $photoId)
    {
        $photo_input = $request->get("photo");

        /* @var Photo $photo */
        $photo = Photo::find($photoId);
        $photo->description = $photo_input['description'];
        $photo->save();

        return redirect("/backend/admin/project/$projectId/edit/third");

    }

}
