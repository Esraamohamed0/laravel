@extends('layouts.app')

@section('title') Show @endsection

@section('content')
{{-- <img src="{{asset($post->image_path)}}"> --}}
            {{-- @dd(Storage::url($post->image_path),$post->image_path,asset($post->image_path)); --}}
            @if($post->image_path !=null)
    <img src="{{ Storage::url($post->image_path) }}" width="250" alt="ll"/>
@endif
    <br>
<br>
    <div class="card mt-6">
        <div class="card-header">
            Post Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Title: {{$post['title']}}</h5>
            <p class="card-text">Description: {{$post['description']}}</p>
        </div>
    </div>
<br>
    <div class="card mt-6">
        <div class="card-header">
            Post Creator Info
        </div>
        <div class="card-body">
        <h5 class="card-title">Name: {{$post->user->name}}</h5>
            <h6 class="card-text">Email: {{$post->user->email}}</h6>
            <h6 class="card-text">Created At: {{$post->created_at->format("l jS \\of F Y h:i:s A")}}</h6>
            </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            Comments
        </div>
        <div class="card-body">
            <form action="{{route('comments.store', ['commentable_id' => $post['id'], 'commentable_type' => get_class($post)])}}" method="POST">
                @csrf
                <label for="exampleFormControlTextarea1" class="form-label">By</label>
                <select name="user_id" class="form-control">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <br>
                <div class="form-group">
                    <textarea name="body" id="body" cols="15" rows="4" class="form-control" placeholder="Your comment here"></textarea>
                </div>

                <div class="form-group">
                    <br>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </form>
            <br>
            
        </div>
        </div>
        <br>
        @if(count($post->comments) > 0)
            @foreach($post->comments as $comment)
            <div class="card">
                <div class="card-header">
                    {{$comment->user->name}}
                </div>
                <div class="card-body">
                    <div>
                        <span style="font-size: 1.2rem; font-weight: bold">Comment: </span>
                        {{$comment->body}}
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div>No comments yet</div>
            @endif
            <br>

@endsection