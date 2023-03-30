@extends('questions.template')
@section('title', 'Subjects')
@section('content')
<div class="p-4">
  <h1 class="h2 text-white-50">Subjects</h1>
  <div class="text-white d-flex p-4 flex-wrap justify-content-center">

    @foreach($subjects as $subject)
      <a href="{{route('exam.exam', $subject -> id)}}">
        <div class="card m-2 p-2 bg-secondary" style="width: 18rem;">
          <div class="card-body">
            <p class="card-text">{{$subject -> name}}</p>
          </div>
        </div>
      </a>
    @endforeach
      
      
  </div>
</div>
  
  
@endsection