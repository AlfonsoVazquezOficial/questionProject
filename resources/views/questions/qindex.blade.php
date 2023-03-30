@extends('questions.template')
@section('title', 'Question Index')
@section('content')
<div class="p-4">
  <h1 class="h2 text-white-50">Questions</h1>
<table class="table table-dark">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Question</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        @foreach ($questions as $question)
        <tr>
            <td>{{$question -> id}}</td>
            <td>{{$question -> questionDesc}}</td>
            <td>
              <button class="btn btn-outline-success" onclick="location.href='{{route('questions.show', $question)}}'">Edit</button>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  <?php
    $counter = $question -> id;
    $counter = $counter / 15;
    $counter = round($counter);
    ?>
    <div class="d-flex justify-content-center">
        <button class="btn btn-secondary" onclick="location.href='{{route('dashboard')}}/?page={{($counter) - 1}}'">Back</button>
        <button class="btn btn-secondary" onclick="location.href='{{route('dashboard')}}/?page={{($counter) + 1}}'">Next</button>
    </div>
</div>
  
  
@endsection