@extends('components.master')
@include('components.nav')

<div class="container-fluid">
    <div class="row justify-content-center">
        <h2 class="card-header w-100 m-1 text-center">Upload with Pixabay</h2>
    </div>
    <div class="row justify-content-center">
  
        <form class="m-2" method="get" action="/pixa-upload" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
{{--                <label for="name">Search Image</label>--}}
                <input type="text" class="form-control" id="img" placeholder="Enter file Name" name="img" >
            </div>
          
            <button type="submit" class="btn btn-dark d-block w-75 mx-auto">Search</button>
        </form>
    </div>
    <ul>
      
</ul>
    @include('components.errors')
</div>
