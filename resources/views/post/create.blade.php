@extends('layouts.app')

@section('title') Show @endsection

@section('content')
<form action="{{route('posts.store')}}">
  <div class="form-group">
    <label for="exampleInputEmail1">Titel</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
  </div>
  <br>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Describtion</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  <br>
  <div class="form-group">
    <label for="exampleInputEmail1">Post creator</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
  </div>
  <br>
  <!-- <button type="submit" class="btn btn-success"></a>create</button> -->
  <x-button type="submit" class="btn btn-success">create</x-button>

</form>
@endsection