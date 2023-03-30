@extends('questions.template')
@section('title', 'Exam Validation')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>


<div class="p-4">
  <h1 class="h2 text-white-50">Exam Validation</h1>
  <div id="exam-content" class="text-white d-flex flex-column p-4 justify-content-center">

    @for ($i = 0; $i < count($questions); $i++)
        @php
            $question = $questions[$i];
            $answer = $answersA[$i];
            if($answer -> isCorrect) {
                $answerClass = 'bg-success';
            } else {
                $answerClass = 'bg-danger';
            }
        @endphp
        <div class="d-flex justify-content-center">
            <div class="card m-2 p-2 {{$answerClass}}" style="width: 50rem;">
              <div class="card-body">
                <h4 class="h4"># {{$question -> id}}</h4>
                <form id="form-{{$question -> id}}" class="form">
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
                        <fieldset disabled="disabled" class="text-white-50">
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
                        </fieldset>
                    </div>
                    
                </form>
                @if ($answerClass == 'bg-danger')
                    @if ($typeAnswer == 'input')
                        <h4 class="h4">Answers:</h4>
                        <div>
                            {{$question -> optionA}} ,
                            {{$question -> optionB}} ,
                            {{$question -> optionC}} ,


                        </div>
                    @else
                        <h4 class="h4">Answer: {{$question -> answer}}</h4>

                    @endif
                    
                @endif
              </div>
            </div>
          </div>

    @endfor
    <div class="d-flex justify-content-end pr-4">
        <p class="h4 text-white-50 pr-4" id="resultExam">Result: </p>
    </div>

    <script type="text/javascript">
        let resultExam = document.getElementById("resultExam");
        let answers = cleanArray(<?php echo json_encode($answersA)?>);
        let questions = cleanArray(<?php echo json_encode($questions)?>);
        let result = 0;
        
        
        setResult();
    
        function setResult() {
            let count = 0;
            answers.forEach(element => {
                if(element.isCorrect) {
                    count++;
                }
                setAnswersUser(element, element.id);
            });

            
            let result = (count / 10) * 100;
            
            
            console.log(result);
            console.log(resultExam);
            resultExam.innerText = "Result: " + result + " / 100";
        }

        function setAnswersUser(answerUser, formNumber) {
            let answer = answerUser.option;
    
            let optionA = document.getElementById("optionA-" + formNumber);
            let optionB = document.getElementById("optionB-" + formNumber);
            let optionC = document.getElementById("optionC-" + formNumber);
            let checkAnswer = document.getElementById("checkAnswer-" + formNumber);

            switch(answer) {
                case "A": 
                    optionA.checked = true;
                break;
                case "B": 
                    optionB.checked = true;
                break;
                case "C": 
                    optionC.checked = true;
                break;
                default: 
                    checkAnswer.value = answer;
                break;
            }
        }
    
    
        function validateAnswer(answer, optionS) {
          let isCorrect = false;
          if(answer == optionS) {
              isCorrect = true;
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
            let answerUser = answers[index].option;

            if(questions[index].type == "input") {
                doc.text(25 , startY + (20 * index) + 10, "Your answer " + answers[index].option);

            } else {
                doc.text(25 , startY + (20 * index) + 10, printAnswer(answerUser, "A") + question.optionA);
                doc.text(25 , startY + (20 * index) + 20, printAnswer(answerUser, "B") + question.optionB);
                doc.text(25 , startY + (20 * index) + 30, printAnswer(answerUser, "C") + question.optionC);
            }

            
            if(! answers[index].isCorrect) {
                if(questions[index].type == "input") {
                    doc.text(25 , startY + (20 * index) + 20, ("Options: " + question.optionA + ", " + question.optionB + ", " + question.optionC) );

                }
                doc.text(20, startY + (20 * index) + 40, "Wrong answer");
                startY += 10;
            }
    
            startY += 40;
            if(index == 4) {
              doc.addPage();
            }
          }
          let userResult = document.getElementById("resultExam");
          doc.text(20, startY + 60, resultExam.innerText);
          
          doc.save("ExamResults");
    
        }

        function printAnswer(answer, space) {
            if(answer == space) {
                return "(  x  )";
            }
            return "(     )";
        }
    
      </script>
    

    
      
      <button class="btn btn-outline-secondary" onclick="printExam()">Print!</button>
      <button class="btn btn-outline-secondary" onclick="location.href='{{route('welcome')}}'">Return Home</button>


  </div>
</div>
  
  
@endsection
