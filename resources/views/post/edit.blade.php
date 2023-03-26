@extends('layouts.app')

@section('title')
    Edit
@endsection

@section('content')
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{route('posts.update',['post' => $post['id']])}}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <input type="hidden" name="id" value={{ $post->id }} class="form-control" id="exampleFormControlInput1">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" id="exampleFormControlInput1" value="{{$post->title}}">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$post->description}}
            </textarea>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Post Creator</label>
            <select name="post_creator" class="form-control">
              <option value="{{ $post['user_id'] }}" selected hidden>{{ $post->user->name }}</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputImage" class="form-label fs-4">Image </label><i class="text-secondary"> (Optional)</i>
            <input type="file" name="image" accept=".jpg,.png" class="form-control" id="exampleInputImage">
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
@endsection