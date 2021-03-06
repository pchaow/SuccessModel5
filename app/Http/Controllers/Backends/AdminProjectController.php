<?php

namespace App\Http\Controllers\Backends;

use App\Services\ProjectService;
use App\Models\Faculty;
use App\Models\Project\Photo;
use App\Models\Project\Project;
use App\Models\Project\ProjectStatus;
use App\Models\Project\Youtube;
use Faker\Provider\Uuid;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use League\Glide\Server;
use Symfony\Component\HttpFoundation\Request;
use \Auth;

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

        if ($user = Auth::user()) {
            $project->createBy()->associate($user);
        }


        return redirect('/backend/admin/project');

    }

    public function editForm(Request $request, $id, $step = "first")
    {
        $project = Project::find($id);
        if ($project) {
            return view("backends.admins.project-editform")
                ->with('project', $project)
                ->with('step', $step);
        } else {
            return redirect('backend/admin/project');
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

        return redirect('/backend/admin/project');
    }

    public function doDelete(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return redirect('backend/admin/project');
        } else {
            $project->delete();
        }

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

            if (!$project) {
                return redirect('backend/admin/project');
            }

            $project->cover_file = $newFileName;
            $project->save();

        }

        return redirect("/backend/admin/project/$id/edit/second");
    }

    public function getCover(Server $server, Request $request, $id, $file)
    {
        return ProjectService::getCover($server, $request, $id, $file);
    }

    public function doUploadPhoto(Server $server, Request $request, $id)
    {
        /* @var Project $project */
        $project = Project::find($id);
        if (!$project) {
            return redirect('backend/admin/project');
        }

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


            $server->makeImage("project/$id/photo/$newFileName", [
                'w' => 300,
                'h' => 300
            ]);

            $project->photos()->save($photo);
        }

        return redirect("/backend/admin/project/$id/edit/third");
    }

    public function doGenerateImageCache(Server $server, Request $request, $id)
    {
        $project = Project::find($id);
        $photos = $project->photos;
        foreach ($photos as $photo) {
            $server->makeImage("project/$id/photo/$photo->filename", [
                'w' => 300,
                'h' => 300
            ]);
        }
    }

    public function getPhoto(Server $server, Request $request, $id, $file)
    {
        return ProjectService::getPhoto($server, $request, $id, $file);
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

    private function youtube_id_from_url($url)
    {
        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';
        $result = preg_match($pattern, $url, $matches);
        if (false !== $result) {
            return $matches[1];
        }
        return false;
    }


    public function doAddYoutube(Request $request, \Alaouy\Youtube\Facades\Youtube $youtubeApi, $projectId)
    {
        $youtube_input = $request->get("youtube");

        $youtube = new Youtube();
        $youtube->url = $youtube_input["url"];
        $youtube->project_id = $projectId;

        $youtubeId = $youtubeApi::parseVidFromURL($youtube->url);


        $youtube->youtube_id = $youtubeId;

        $videoInfo = $youtubeApi::getVideoInfo($youtubeId);
        //dd($videoInfo);

        $youtube->title = $videoInfo->snippet->title;
        $youtube->description = $videoInfo->snippet->description;
        $youtube->embedHtml = "<iframe width=\"320\" height=\"240\" src=\"//www.youtube.com/embed/$youtubeId\" frameborder=\"0\" allowfullscreen></iframe>";
        $youtube->save();

        return redirect("/backend/admin/project/$projectId/edit/forth");

    }

    public function doDeleteYoutube(Request $request, $projectId, $youtubeId)
    {
        $youtube = Youtube::find($youtubeId);
        $youtube->delete();

        return redirect("/backend/admin/project/$projectId/edit/forth");
    }

    public function doAddUser(Request $request, $projectId)
    {
        $user_add_form = $request->get('user');


        /* @var Project $project */
        $project = Project::find($projectId);
        if (!$project) {
            return redirect('backend/admin/project');
        }

        if ($project->users()->find($user_add_form["id"]) == null) {
            $project->users()->attach($user_add_form["id"]);
            return redirect("/backend/admin/project/$projectId/edit/fifth");
        } else {
            $error = new MessageBag([
                "ADD_USER_ERROR" => "คุณได้เพิ่มนักวิจัยคนนี้ไปแล้ว"
            ]);
            return redirect("/backend/admin/project/$projectId/edit/fifth");
        }


    }

    public function doDeleteUser(Request $request, $projectId, $userId)
    {
        /* @var Project $project */
        $project = Project::find($projectId);
        if (!$project) {
            return redirect('backend/admin/project');
        }
        $project->users()->detach($userId);
        return redirect("/backend/admin/project/$projectId/edit/fifth");
    }

    public function doSaveMap(Request $request, $projectId)
    {
        $project_form = $request->get('project');

        $project = Project::find($projectId);
        if (!$project) {
            return redirect('backend/admin/project');
        }
        $project->geojson = $project_form['geojson'];
        $project->save();

        return redirect("/backend/admin/project/$projectId/edit/sixth");

    }
}
