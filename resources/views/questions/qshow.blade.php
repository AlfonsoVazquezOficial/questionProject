@extends('questions.template')
@section('title', 'Show')
@section('content')
<div class="p-4 bg-dark text-white">
  <h1 class="h2 text-white-50">Show</h1>
  <div>
    <form class="form">
        <div class="form-group">
            <label class="form-check-label" for="type">Type</label>
            <select disabled id="select-type" class="form-select">
                <option
                @if ($question -> type == "radio")
                    selected
                @endif
                 value ="radio">Radio</option>
                <option
                @if ($question -> type == "checkbox")
                    selected
                @endif
                 value ="checkbox">Checkbox</option>
                <option
                @if ($question -> type == "input")
                    selected
                @endif
                 value ="input">Input</option>
            </select><br>
            <label for="question">Question</label>
            <input class="form-control" type="text" readonly id="question" name="question" value={{$question -> questionDesc}}><br>
            <label class="form-check-label">Subject </label><br>
            <select disabled class="form-select" id="id_subject" name="id_subject" aria-label="Default select example">
                <option selected>Select a subject</option>

                @foreach($subjects as $subject)
                <option 
                @if (($subject -> id) == ($question -> id_subject))
                    selected 
                @endif
                value="{{$subject -> id}}">{{$subject -> name}}</option>
                @endforeach
            </select><br>
    </div>
        
        <div class="form-check">
            @php
                $typeAnswer = $question -> type;
                $classInput = "form-check-input";
                $evaluateMethod = "validateAnswer('{$question -> answer}')";
                if($typeAnswer == "input") {
                    $classInput = "form-control";
                    $evaluateMethod = "validateAnswerInput()";
                }
            @endphp
            @if ($typeAnswer == "input")
                <label class="form-check-label" for="optionA">Option A</label>
                <input readonly class="{{$classInput}}" type="text" id="optionA" name="options" value="{{$question -> optionA}}"><br>
                <label class="form-check-label" for="optionB">Option B</label>
                <input class="{{$classInput}}" type="text" id="optionB" name="options" value="{{$question -> optionB}}"><br>
                <label readonly class="form-check-label" for="optionC">Option C</label>
                <input readonly class="{{$classInput}}" type="text" id="optionC" name="options" value="{{$question -> optionC}}"><br>
                <label class="form-check-label" for="checkAnswer">Check Answer</label>
                <input class="{{$classInput}}" type="text" id="checkAnswer" value=""><br>

            @else
                <label class="form-check-label" for="optionA">Option A</label>
                <input class="{{$classInput}}" type="{{$typeAnswer}}" id="optionA" name="options">{{$question -> optionA}}<br>
                <label class="form-check-label" for="optionB">Option B</label>
                <input class="{{$classInput}}" type="{{$typeAnswer}}" id="optionB" name="options">{{$question -> optionB}}<br>
                <label class="form-check-label" for="optionC">Option C</label>
                <input class="{{$classInput}}" type="{{$typeAnswer}}" id="optionC" name="options">{{$question -> optionC}}<br>
                <br>
            @endif

            
        </div>
        
        <!--
        <label for="question">Answer</label>
        <input type="text" id="question" name="question" value={{$question -> answer}}><br>
        -->
        
        
        
    </form>
    <button class="btn btn-outline-success" onclick={{$evaluateMethod}}>Validate</button>
    <button onclick="location.href='{{route('questions.edit', ($question))}}'" class="btn btn-outline-warning">Edit Question</button>

    <form action="{{route('questions.destroy', $question)}}" method="POST">
        @csrf
        @method('delete')
        <button class="btn btn-outline-danger" type="submit" name="">Delete</button>
    </form>

</div>

<script type="text/javascript">

    let optionA = document.getElementById("optionA");
    let optionB = document.getElementById("optionB");
    let optionC = document.getElementById("optionC");
    let type = document.getElementById("select-type");
    let checkAnswer = document.getElementById("checkAnswer");

    function validateAnswer(answer) {
        let message;
        if(answer == validateOptions()) {
            message = "Right answer";;
        } else {
            message = "Wrong answer";;
        }
        console.log(message);
        console.log(validateOptions());
        alert(message);
    }

    function validateAnswerInput() {
        let message = "Wrong answer";
        if(
            checkAnswer.value.toLowerCase() == optionA.value.toLowerCase() || 
            checkAnswer.value.toLowerCase() == optionB.value.toLowerCase() || 
            checkAnswer.value.toLowerCase() == optionC.value.toLowerCase()
            ) {
                message = "Right answer";
                checkAnswer.value = "";
            }
        alert(message);
    }

    function validateOptions() {
        if(optionA.checked) {
            return "A";
        }
        if(optionB.checked) {
            return "B";
        }
        if(optionC.checked) {
            return "C";
        }
    }
</script>

 <!-- la siguiente linea es por si pagina -->
<button class="btn btn-secondary" type="button" onclick="location.href='{{route('questions.show', ($question -> id) - 1)}}'">Back</button>
<button class="btn btn-secondary" type="button" onclick="location.href='{{route('questions.show', ($question -> id) + 1)}}'">Next</button>
</div>
  
  
@endsection