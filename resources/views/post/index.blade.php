@extends('layouts.app')


@section('title') Index @endsection

@section('content')
    <div class="text-center">
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('posts.create')}}" class="btn btn-success">Create Post</a></button>
    </div>
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Slug</th>
            <th scope="col">Posted By</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach($posts as $post)
            <tr>
                <td>{{$post['id']}}</td>
                <td>{{$post['title']}}</td>
                <td >{{$post->slug}}</td>
                @if($post->User)
                    <td>{{$post->User->name}}</td>
                @else
                    <td>Not Found</td>
                @endif
                <td>{{$post->created_at->format("Y-m-d")}}</td>
                <td>
                <a href="{{route('posts.show', $post->id)}}" class="btn btn-info">View</a>
                    <a href="{{route('posts.edit', $post->id)}}" class="btn btn-primary">Edit</a>
                    <form style="display: inline" method="POST" action="{{ route('posts.destroy', $post->id) }}">
                        @method('DELETE')
                        @csrf
                        <button onclick="return confirm('Are you sure you want to delete this post?')" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach



        </tbody>
    </table>
    {{$posts->links('pagination::bootstrap-4')}}

@endsection

