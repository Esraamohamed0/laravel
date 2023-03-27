<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $allPosts =  Post::with('user')->paginate(5);
        return PostResource::collection($allPosts);
    }

    public function show($post)
    {
        $post =  Post::find($post);
        return new PostResource($post);
    }

    public function store(StorePostRequest $request)
    {
        $path = null;

         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $path = Storage::putFileAs('public/posts', $image, $filename);
            $post_image = explode("/", $path);
            array_shift($post_image);
            $post_image = join("/", $post_image);
            $path = $post_image;
        }

        $post = Post::create([
            'title' =>  $request->title,
            'description' => $request->description,
            'user_id' => $request->post_creator,
            'image_path' => $path
        ]);

        return new PostResource($post);
    }
}