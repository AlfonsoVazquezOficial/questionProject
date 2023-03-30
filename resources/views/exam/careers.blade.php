@extends('questions.template')
@section('title', 'Careers')
@section('content')
@php
  $careers = [
    [
      'name' => 'Ingeniería Cívil',
      'photoUrl' => 'civil.jpg',
      'href' => 'IC'
    ],
    [
      'name' => 'Ingeniería en Sistemas Computacionales',
      'photoUrl' => 'sistemas.jpeg',
      'href' => 'ISC'
    ],
    [
      'name' => 'Ingeniería Informática',
      'photoUrl' => 'informatica.jpg',
      'href' => 'IF'
    ],
    [
      'name' => 'Contador Público',
      'photoUrl' => 'contador.jpg',
      'href' => 'CP'
    ],
    [
      'name' => 'Gestión Empresarial',
      'photoUrl' => 'gestion.jpg',
      'href' => 'IGE'
    ]
  ];
@endphp
<div class="p-4">
  <h1 class="h2 text-white-50">Careers</h1>
  <div class="text-white d-flex p-4 flex-wrap justify-content-center">

    @foreach($careers as $career)
      <a href="{{route('exam.subjects', $career['href'])}}">
        <div class="card m-2 p-2 bg-secondary" style="width: 18rem;">
          <img class="card-img-top" src="{{URL::to('/images')}}/{{$career['photoUrl']}}" alt="{{$career['name']}}">
          <div class="card-body">
            <p class="card-text">{{$career['name']}}</p>
          </div>
        </div>
      </a>
    @endforeach
      
      
  </div>
</div>
  
  
@endsection