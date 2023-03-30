@extends('questions.template')
@section('title', 'Welcome')
@section('content')
<div class="p-4 bg-dark text-white">
    <div class="d-flex justify-content-between">
        <h1 class="h2 text-white-50">Welcome
        </h1>
        <h4 class="h4 text-white-50">
          @php
              $user = Auth::user();
      
              $userName = $user['name'];
              $userImageSrc = $user['imgSrc'];
              $userType = $user['type'];
            echo $userName;
          @endphp
        </h4>
    </div>
    <div class=" d-flex p-4 pb-0  justify-content-center" style="height: 250px;">
        <img class="rounded-circle h-100 img-thumbnail" src="{{$userImageSrc}}" />
        
    </div>
    <div class="d-flex justify-content-center pt-0">
      <h4 class="d-inline h4 text-white-50">
        {{$userType}}
      </h4>
    </div>
    
    

</div>
  
  
@endsection
