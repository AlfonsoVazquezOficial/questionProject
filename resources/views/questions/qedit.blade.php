@extends('questions.template')
@section('title', 'Edit')
@section('content')
<div class="p-4 bg-dark text-white">
  <h1 class="h2 text-white-50">Edit</h1>
  <div>
    <form action="{{route('questions.update', $question)}}" method="POST" onsubmit="sendResult()" class="form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-check-label" for="type">Type</label>
            <select name="type" id="select-type" class="form-select">
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
            <label class="form-check-label" for="question">Question</label>
            <input class="form-control" type="text" id="question" name="questionDesc" value={{$question -> questionDesc}}><br>
            <label class="form-check-label">Option A </label>
            <input class="form-control" type="text" id="optionA" name="optionA" value={{$question -> optionA}}><br>
            <label class="form-check-label">Option B </label>
            <input class="form-control" type="text" id="optionB" name="optionB" value={{$question -> optionB}}><br>
            <label class="form-check-label">Option C </label>
            <input class="form-control" type="text" id="optionC" name="optionC" value={{$question -> optionC}}><br>
            <label class="form-check-label">Subject </label><br>
            <select class="form-select" id="id_subject" name="id_subject" aria-label="Default select example">
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
        
            <label class="form-check-label">Answer:</label><br>
            <input class="form-check-input" type="radio" id="answerA" name="answer" value = "A">A<br>
            <input class="form-check-input" type="radio" id="answerB" name="answer" value = "B">B<br>
            <input class="form-check-input" type="radio" id="answerC" name="answer" value = "C">C<br>
            <p id="pAnswer" style="visibility: hidden">{{$question -> answer}}</p>
        
        <!--
        <label for="question">Answer</label>
        <input type="text" id="question" name="question" value={{$question -> answer}}><br>
        -->
        
        <button onclick="" class="btn btn-outline-success">Edit Question</button>
        
    </form>
    

</div>

<script type="text/javascript">
    let answerA = document.getElementById("answerA");
    let answerB = document.getElementById("answerB");
    let answerC = document.getElementById("answerC");

    let questionDesc = document.getElementById("questionDesc");
    let optionA = document.getElementById("optionA");
    let optionB = document.getElementById("optionB");
    let optionC = document.getElementById("optionC");

    let answer = document.getElementById("pAnswer").textContent;
    let selectType = document.getElementById("select-type");

    onload();

    function onload() {
        setAnswer(answer);
    }

    function setAnswer(answer) {
        switch (answer) {
            case "A": 
                answerA.checked = true;
            break;
            case "B": 
                answerB.checked = true;
            break;
            case "C": 
                answerC.checked = true;
            break;

        }
    }

    function sendResult() {
        let answer = validateRadioButton();
        let type = selectType.value;
        let question = {
            type: type,
            questionDesc: questionDesc,
            optionA: optionA,
            optionB: optionB,
            optionC: optionC,
            answer: answer
        }
        return answer;
    }

    function validateRadioButton() {
        if(answerA.checked) {
            return answerA.value;
        }
        if(answerB.checked) {
            return answerB.value;
        }
        if(answerC.checked) {
            return answerC.value;
        }
    }
</script>

 <!-- la siguiente linea es por si pagina -->
<button class="btn btn-secondary" type="button" onclick="location.href='{{route('questions.show', ($question -> id) - 1)}}'">Back</button>
<button class="btn btn-secondary" type="button" onclick="location.href='{{route('questions.show', ($question -> id) + 1)}}'">Next</button>
</div>
  
  
@endsection