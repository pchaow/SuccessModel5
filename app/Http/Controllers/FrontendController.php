<?php

namespace App\Http\Controllers;

use App\Models\Posts\Post;
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
        })->limit(6)->orderBy('updated_at', 'desc')->get();

        $posts = Post::whereHas('status', function ($q) {
            $q->where('key', '=', 'published');
        })->limit(6)->orderBy('updated_at', 'desc')->get();

        return view('frontends.index')
            ->with('projects', $projects)
            ->with('posts', $posts);
    }

    public function project(Request $request, $projectId)
    {

        $project = Project::with(['photos', 'youtubes'])->find($projectId);

        return view('frontends.project')
            ->with('project', $project);

    }

    public function getPost(Request $request, $postId)
    {
        $post = Post::find($postId);
        return view('frontends.post')
            ->with('post', $post);
    }

}
