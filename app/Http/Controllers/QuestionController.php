<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    //
    public function index() {
        $questions = Question::paginate();
        return view('questions.qindex', compact('questions'));
    }

    public function show(Question $question) {
        $subjects = DB::table('subjects') -> get();
        return view('questions.qshow', compact('question', 'subjects'));
    }

    public function create() {
        $subjects = DB::table('subjects') -> get();
        return view('questions.qcreate', compact('subjects'));
    }

    public function store(Request $request) {
        $question = new Question();

        $question -> type = $request -> type;
        $question -> questionDesc = $request -> questionDesc;
        $question -> optionA = $request -> optionA;
        $question -> optionB = $request -> optionB;
        $question -> optionC = $request -> optionC;
        $question -> answer = $request -> answer;
        $question -> id_subject = $request -> id_subject;

        $question -> save();

        return redirect() -> route('questions.show', $question);
    }

    public function edit(Question $question) {
        $subjects = DB::table('subjects') -> get();
        return view('questions.qedit', compact('question', 'subjects'));
    }

    public function update(Request $request, Question $question) {

        
        $question -> type = $request -> type;
        $question -> questionDesc = $request -> questionDesc;
        $question -> optionA = $request -> optionA;
        $question -> optionB = $request -> optionB;
        $question -> optionC = $request -> optionC;
        $question -> answer = $request -> answer;

        $question -> save();
        return redirect() -> route('questions.show', $question);
    }

    public function destroy(Question $question) {
        $question -> delete();
        return redirect() -> route('dashboard');
    }

    
}
