<?php

namespace App\Http\Controllers\Backends;

use App\Models\Posts\Post;
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

    }

    public function editForm(Request $request, $id, $step = "first")
    {

    }


    public function doEdit(Request $request, $id)
    {

    }

    public function doDelete(Request $request, $id)
    {

    }

    public function doSubmit(Request $request, $id)
    {
    }


    public function preview(Request $request, $id, $role)
    {


    }


}
