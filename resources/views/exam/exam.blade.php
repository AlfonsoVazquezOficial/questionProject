@extends('questions.template')
@section('title', 'Exam')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>


<div class="p-4">
  <h1 class="h2 text-white-50">Exam</h1>
  <div id="exam-content" class="text-white d-flex flex-column p-4 justify-content-center">


    @foreach($questions as $question)
      <div class="d-flex justify-content-center">
        <div class="card m-2 p-2 bg-secondary" style="width: 50rem;">
          <div class="card-body">
            <h4 class="h4"># {{$question -> id}}</h4>
            <form id="form-{{$question -> id}}" class="form" onsubmit="saveAnswer()">
                <div class="form-group">
                    <label for="question">Question</label>
                    <input class="form-control" type="text" readonly id="question" name="question" value={{$question -> questionDesc}}><br>
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
                  <div style="display:none; visibility: hidden;">
                    <label class="form-check-label" for="optionA">Option A</label>
                    <input readonly class="{{$classInput}}" type="text" id="optionA-{{$question -> id}}" name="options" value="{{$question -> optionA}}"><br>
                    <label class="form-check-label" for="optionB">Option B</label>
                    <input class="{{$classInput}}" type="text" id="optionB-{{$question -> id}}" name="options" value="{{$question -> optionB}}"><br>
                    <label readonly class="form-check-label" for="optionC">Option C</label>
                    <input readonly class="{{$classInput}}" type="text" id="optionC-{{$question -> id}}" name="options" value="{{$question -> optionC}}"><br>
                  </div>
                  
                  <label class="form-check-label" for="checkAnswer">Answer</label>
                  <input class="{{$classInput}}" type="text" id="checkAnswer-{{$question -> id}}" value=""><br>
  
              @else
                  <label class="form-check-label" for="optionA">Option A</label>
                  <input class="{{$classInput}}" type="{{$typeAnswer}}" id="optionA-{{$question -> id}}" name="options">{{$question -> optionA}}<br>
                  <label class="form-check-label" for="optionB">Option B</label>
                  <input class="{{$classInput}}" type="{{$typeAnswer}}" id="optionB-{{$question -> id}}" name="options">{{$question -> optionB}}<br>
                  <label class="form-check-label" for="optionC">Option C</label>
                  <input class="{{$classInput}}" type="{{$typeAnswer}}" id="optionC-{{$question -> id}}" name="options">{{$question -> optionC}}<br>
                  <br>
              @endif
                </div>
                
            </form>
            <button onclick="saveAnswer({{$question -> id}})" type="submit" class="btn btn-dark">Save Answer</button>
          </div>
        </div>
      </div>
      
    @endforeach
    

    <form action="{{route('exam.validate')}}" method="POST" onsubmit="sendResult()" class="form">
        @csrf
        <textarea title="answers" name="answers" id="answers" rows="0" style="visibility:collapse"></textarea>
        
        <br>
        <button class="btn btn-outline-secondary w-100">Finish!</button>
    </form>
      
      <button class="btn btn-outline-secondary" onclick="printExam()">Print!</button>

  </div>
</div>
  
  
@endsection
<script type="text/javascript">
  let answers = [];
  let questions = cleanArray(<?php echo json_encode($questions)?>);

  function saveAnswer(formNumber) {
    let question = questions.find(({id}) => id == formNumber);
    let answer = question.answer;
    let type = question.type;
    
    let optionA = document.getElementById("optionA-" + formNumber);
    let optionB = document.getElementById("optionB-" + formNumber);
    let optionC = document.getElementById("optionC-" + formNumber);

    let optionSelected = validateOptions(optionA, optionB, optionC);

    if(question.type == 'input') {
      optionSelected = document.getElementById("checkAnswer-" + question.id).value;
    }

    saveOnArrayAnswer(formNumber, optionSelected, validateAnswer(answer, optionSelected, question));
    
  }

  function saveOnArrayAnswer(number, option, isCorrect) {
    isSaved = searchSavedAnswers(number);
    if(isSaved == -1) {
      answers.push({
        "id": number,
        "option": option,
        "isCorrect": isCorrect
      });
    } else {
        answers.splice(isSaved, 1,{
          "id": number,
          "option": option,
          "isCorrect": isCorrect
        });
    }
    
    console.log(answers);
    
  }

  function searchSavedAnswers(number) {
    return answers.findIndex(({id}) => id == number);
  }

  function validateAnswer(answer, optionS, type) {
    let isCorrect = false;
    let checkAnswer = document.getElementById("checkAnswer-" + question.id);
    if(question.type != "input") {
      if(answer == optionS) {
        isCorrect = true;
      }
    } else {
      if(
            checkAnswer.value.toLowerCase() == optionA.value.toLowerCase() || 
            checkAnswer.value.toLowerCase() == optionB.value.toLowerCase() || 
            checkAnswer.value.toLowerCase() == optionC.value.toLowerCase()
            ) {
              isCorrect = true;
            }
    }
    return isCorrect;
  }

  function validateOptions(optionA, optionB, optionC) {
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

  function cleanArray(dArray) {
      return dArray.filter(Boolean);
  }

  function printExam() {
    
    let doc = new jsPDF();
    let startY = 20;

    doc.text(20, startY, "Exam");
    
    doc.setFontSize(12);
    startY = 30;
    for (let index = 0; index < questions.length; index++) {
      const question = questions[index];
      doc.text(20 , startY + (20 * index), "No. " + question.id);
      doc.text(40 , startY + (20 * index), "" + question.questionDesc);
      if(question.type != "input") {
        doc.text(25 , startY + (20 * index) + 10, "(     )" + question.optionA);
        doc.text(25 , startY + (20 * index) + 20, "(     )" + question.optionB);
        doc.text(25 , startY + (20 * index) + 30, "(     )" + question.optionC);
      } else {
        doc.text(25 , startY + (20 * index) + 10, "______________________________");
      }
      

      startY += 40;
      if(index == 4) {
        doc.addPage();
      }
    }
    
    doc.save("Exam");

  }

  function sendResult() {
    let textarea = document.getElementById("answers");
    textarea.value = JSON.stringify(answers);
    return JSON.stringify(answers);
  }
</script>