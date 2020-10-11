@extends('components.master')
@include('components.nav')
<html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <h2 class="card-header w-100 m-1 text-center">Upload with Pixabay</h2>
    </div>
    <div class="row justify-content-center">
  
        <form class="m-2" method="get" action="/pixa-upload" >
            @csrf
            <div class="form-group">
{{--                <label for="name">Search Image</label>--}}
                <input type="text" class="form-control" id="img" placeholder="Search image" name="img" required />
            </div>
          
            <button type="submit" class="btn btn-dark d-block w-75 mx-auto">Search</button>
        </form>
    </div>

    @if($fetchedData ?? '')
    <div class="container">
    <h3 class="text-center" style="margin-top:20px">- Preview Images -</h3>
    <span class="success" style="color:green; margin-top:10px; margin-bottom: 10px;"></span>
    <div class="row" style="box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23); padding:18px;margin-top:25px;margin-bottom:10px;border-radius:10px">
     @foreach($fetchedData as $fd)
    <form method="post" action="{{ url('add') }}" enctype="multipart/form-data" id="ajaxform">
    
    @csrf
    
    <input name="pixaName" type="hidden" value="{{$selectImages ?? ''}}" class="form-control" id="test">
        
        <div class="col-md-3">
        <input  type="hidden" value="{{$fd ?? '' ?? ''}}" id="pixaURL" class="form-control" name="pixaURL">
    <img src="{{$fd ?? '' ?? ''}}" alt="preview" width="200px" style="border-radius:10px;margin-bottom:10px"  class="img" id="[{{$fd ?? '' ?? ''}}]">
    </div>
      
    <button type="submit" class="btn btn-success" style="margin-top: 10px;display:none" id="tog">Save</button>
</form>
 @endforeach
    </div>
</div>
@else
<p class="text-center">No image selected yet</p>
@endif
    @include('components.errors')
</div>
</body>
<script>
    var name = '';
    var images = [];
    
    $("img").click(function(event) {
        $("#tog").show();
            name = $('input[name="pixaName"]').val();
            var url = $(this).attr('src');
            
            var exists = images.includes(url)
            if (!exists) {
                images.push(url);
            }
              
        $(this).addClass("activeImage");
  });

  $("#tog").click(function(event){
      event.preventDefault();
        $('img').removeClass('activeImage');
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : '/add',
        type : 'POST',
        data : {
            pixaName : name,
            pixaURL : images
        }, 
        success : function(response){
            console.log(response)
        }    
      });
      
  });
</script>
</html>