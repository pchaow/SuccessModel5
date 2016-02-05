<?php

namespace App\Http\Controllers\Backends;

use App\Models\Posts\Photo;
use App\Models\Posts\Post;
use App\Models\Posts\PostStatus;
use App\Services\PostService;
use Faker\Provider\Uuid;
use Illuminate\Routing\Controller as BaseController;

use League\Glide\Server;
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
            ->with("post", $post)
            ->with('step', $step);

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
        $post = Post::find($id);

        $publicStatus = PostStatus::where('key', '=', 'published')->first();
        $post->status_id = $publicStatus->id;
        $post->save();

        return redirect("/backend/post");
    }

    public function doSaveCover(Request $request, $id)
    {

        $file = $request->files->get("post")["cover_upload"];
        if ($file->isValid()) {

            $originalExt = $file->getClientOriginalExtension();
            $newFileName = Uuid::uuid() . "." . $originalExt;
            $destinationPath = storage_path("app/post/$id/cover");
            $file->move($destinationPath, $newFileName);

            $post = Post::find($id);

            if (!$post) {
                return redirect('backend/post');
            }

            $post->cover_file = $newFileName;
            $post->save();

        }

        return redirect("/backend/post/$id/edit/second");
    }

    public function getCover(Server $server, Request $request, $id, $file)
    {
        return PostService::getCover($server, $request, $id, $file);
    }

    public function doUploadPhoto(Request $request, $id)
    {
        /* @var Post $post */
        $post = Post::find($id);
        if (!$post) {
            return redirect('backend/project');
        }

        $file = $request->files->get("photo")["file"];
        $photoInput = $request->get('photo');
        if ($file->isValid()) {

            $originalExt = $file->getClientOriginalExtension();
            $newFileName = Uuid::uuid() . "." . $originalExt;
            $destinationPath = storage_path("app/post/$id/photo");
            $file->move($destinationPath, $newFileName);

            $photo = new Photo();
            $photo->description = $photoInput['description'];
            $photo->filename = $newFileName;


            $post->photos()->save($photo);

        }

        return redirect("/backend/post/$id/edit/third");
    }

    public function getPhoto(Server $server, Request $request, $id, $file)
    {
        return PostService::getPhoto($server, $request, $id, $file);
    }

    public function doDeletePhoto(Request $request, $id, $photoId)
    {
        /* @var Photo $photo */
        $photo = Photo::find($photoId);
        $photo->delete();

        return redirect("/backend/post/$id/edit/third");

    }

    public function doEditPhoto(Request $request, $id, $photoId)
    {
        $photo_input = $request->get("photo");

        /* @var Photo $photo */
        $photo = Photo::find($photoId);
        $photo->description = $photo_input['description'];
        $photo->save();

        return redirect("/backend/post/$id/edit/third");

    }


    public function preview(Request $request, $id)
    {

        $post = Post::find($id);

        return view('backends.posts.preview')
            ->with('post', $post);
    }

    public function listPost()
    {
        $posts = Post::all();
        return $posts;
    }

    public function getPost($id)
    {
        $post = Post::with('photos')->where('id', '=', $id)->first();
        return $post;
    }


}
