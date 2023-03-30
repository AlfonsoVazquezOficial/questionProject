@extends('questions.template')
@section('title', 'Create')
@section('content')
<div class="p-4 bg-dark text-white">
  <h1 class="h2 text-white-50">Create</h1>
  <div>
    <form action="{{route('questions.store')}}" method="POST" onsubmit="sendResult()" class="form">
        @csrf
        <div class="form-group">
            <label class="form-check-label" for="type">Type</label>
            <select id="select-type" name="type" class="form-select">
                <option selected value ="radio">Radio</option>
                <option value ="checkbox">Checkbox</option>
                <option value ="input">Input</option>
            </select><br>
            <label class="form-check-label" for="questionDesc">Question</label>
            <input class="form-control" type="text" id="questionDesc" name="questionDesc"><br>
            <label class="form-check-label">Option A </label>
            <input class="form-control" type="text" id="optionA" name="optionA"><br>
            <label class="form-check-label">Option B </label>
            <input class="form-control" type="text" id="optionB" name="optionB"><br>
            <label class="form-check-label">Option C </label>
            <input class="form-control" type="text" id="optionC" name="optionC"><br>
            <label class="form-check-label">Subject </label><br>
            <select class="form-select" id="id_subject" name="id_subject" aria-label="Default select example">
                <option selected>Select a subject</option>

                @foreach($subjects as $subject)
                <option value="{{$subject -> id}}">{{$subject -> name}}</option>
                @endforeach
            </select><br>
        </div>
        
            <label class="form-check-label">Answer:</label><br>
            <input class="form-check-input" type="radio" id="answerA" name="answer" value = "A">A<br>
            <input class="form-check-input" type="radio" id="answerB" name="answer" value = "B">B<br>
            <input class="form-check-input" type="radio" id="answerC" name="answer" value = "C">C<br>
            <button class="btn btn-outline-success" type="submit">Send Result</button>
        
        
        
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

    let selectType = document.getElementById("select-type");

    function sendResult() {
        let answer = validateRadioButton();
        let type = selectType.value;
        let question = {
            type: type,
            questionDesc: questionDesc,
            optionA: optionA,
            optionB: optionB,
            optionC: optionC,
            answer: answer,
            id_subject : parseInt(id_subject)
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
</div>
  
  
@endsection