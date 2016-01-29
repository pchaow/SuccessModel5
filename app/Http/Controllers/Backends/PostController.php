<?php

namespace App\Http\Controllers\Backends;

use App\Models\Posts\Post;
use App\Models\Posts\PostStatus;
use Illuminate\Routing\Controller as BaseController;

use Symfony\Component\HttpFoundation\Request;

class PostController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $posts = Post::all();
        return view("backends.posts.index")
            ->with("posts", $posts);
    }

    public function addForm(Request $request)
    {
        $post = new Post();
        return view("backends.posts.addform")
            ->with("post", $post);
    }

    public function doAdd(Request $request)
    {
        $postForm = $request->get('postForm');

        $post = new Post();
        $post->title = $postForm['title'];
        $post->content = $postForm['content'];

        if ($postForm['status']['id']) {
            $post->status_id = $postForm['status']['id'];
        } else {
            $draftStatus = PostStatus::where('key', '=', 'draft')->first();
            $post->status_id = $draftStatus->id;
        }

        $post->save();

        return redirect("/backend/post");
    }

    public function editForm(Request $request, $id, $step = "first")
    {
        $post = Post::find($id);
        return view("backends.posts.editform")
            ->with("post", $post);
    }


    public function doEdit(Request $request, $id)
    {
        $postForm = $request->get('postForm');
        $post = Post::find($id);
        $post->title = $postForm['title'];
        $post->content = $postForm['content'];

        if ($postForm['status']['id']) {
            $post->status_id = $postForm['status']['id'];
        } else {
            $draftStatus = PostStatus::where('key', '=', 'draft')->first();
            $post->status_id = $draftStatus->id;
        }

        $post->save();

        return redirect("/backend/post");

    }

    public function doDelete(Request $request, $id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect("/backend/post");
    }

    public function doSubmit(Request $request, $id)
    {
    }


    public function preview(Request $request, $id, $role)
    {


    }


}
