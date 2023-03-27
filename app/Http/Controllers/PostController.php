<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\PruneOldPostsJob;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PostController extends Controller
{
    public function index()
    {
        $allPosts = Post::paginate(5);

        return view('post.index', ['posts' => $allPosts]);
    }



    public function show($id)
    {
        $post = Post::find($id);
        $users = User::all();

        return view('post.show', [
            'post' => $post,
            'users' => $users,
            'image_path' => $post->image_path
        ]);
    }



    public function create()
    {
        $users = User::all();
        return view('post.create', ['users' => $users]);
    }



    public function store(StorePostRequest $request)
    {
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;

        $post = Post::create([
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $path = Storage::putFileAs('public/posts', $image, $filename);
            $post_image = explode("/", $path);
            array_shift($post_image);
            $post_image = join("/", $post_image);
            $post->image_path = $post_image;
            $post->save();
        }


        return to_route('posts.index');
    }



    public function edit($id)
    {
        $post = Post::find($id);
        $users = User::all();
        return view('post.edit',['post' => $post,'users' =>$users]);
    }


    public function update(UpdatePostRequest $request)
    {
        // $req = request()->all();
        // Post::where('id', $req['id'])->update([
        //     'title' => $req['title'],
        //     'description' => $req['description'],
        //     'slug' => Str::slug($req['title']),
        //     'user_id' => $req['post_creator']
        // ]);

        $post = Post::findOrFail($request["id"]);

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::delete("public/" . $post->image_path);
            }
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $path = Storage::putFileAs('public/posts', $image, $filename);
            $post_image = explode("/", $path);
            array_shift($post_image);
            $post_image = join("/", $post_image);
            $post->image_path = $post_image;
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'user_id' => $request->post_creator,
        ]);

        return redirect()->route("posts.index");
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image_path && Storage::exists("public/" . $post->image_path)) {
            Storage::delete("public/" . $post->image_path);
        }
        Post::where('id', $id)->delete();
        return redirect()->route("posts.index");
    }



    public function removeOldPosts() {
        PruneOldPostsJob::dispatch();
        return redirect()->route("posts.index");
    }


    public function githubredirect(Request $request)
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubcallback(Request $request)
    {
        $userdata = Socialite::driver('github')->stateless()->user();
        $user = User::where('email', $userdata->email)->first();
        if (!$user) {
            $uuid=Str::uuid()->toString();
            $user = new User();
            $user->name = $userdata->name;
            $user->email = $userdata->email;
            $user->password = Hash::make($uuid.now());
            $user->save();
            Auth::login($user);
            return redirect('/posts');
            }

        else{

            Auth::login($user);
            return redirect('/posts');
        }
    }

    public function googleredirect(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function googlecallback(Request $request)
    {
        $userdata = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $userdata->email)->first();
        if (!$user) {
            $uuid=Str::uuid()->toString();
            $user = new User();
            $user->name = $userdata->name;
            $user->email = $userdata->email;
            $user->password = Hash::make($uuid.now());
            $user->save();
            Auth::login($user);
            return redirect('/posts');
            }

        else{
            Auth::login($user);
            return redirect('/posts');
        }
    }
}