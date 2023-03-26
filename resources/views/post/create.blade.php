@extends('layouts.app')

@section('title')
    Create
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
  <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Titel</label>
    <input type="text" class="form-control" name="title" aria-describedby="emailHelp" >
  </div>
  <br>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Describtion</label>
    <textarea class="form-control" name="description" rows="3"></textarea>
  </div>
  <br>
  <div class="form-group">
    <label for="exampleInputEmail1">Post creator</label>
    <!-- <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" > -->
    <select name="post_creator" class="form-control">
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
  </div>
  <br>
  <div class="mb-3">
            <label for="exampleInputImage" class="form-label fs-4">Image </label><i class="text-secondary"> (Optional)</i>
            <input type="file" name="image" accept=".jpg,.png" class="form-control" id="exampleInputImage">
        </div>
<br>
  <!-- <button type="submit" class="btn btn-success"></a>create</button> -->
  <x-button type="submit" class="btn btn-success">create</x-button>

</form>
@endsection