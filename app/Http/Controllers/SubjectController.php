<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    //
    public function index() {
        $subjects = Subject::all();
        return view('exam.careers', compact('subjects'));
    }

    public function show($career) {
        $subjects = DB::table('subjects') -> where('career', $career) -> get();
        return view('exam.subjects', compact('subjects'));
    }

    public function exam($id_subject) {
        $questions = DB::table('questions') -> where('id_subject', $id_subject) -> inRandomOrder() -> limit(4) -> get();
        return view('exam.exam', compact('questions'));
    }

    public function validateExam(Request $request) {

        $answersA = json_decode($request -> answers);
        $questions = array();
        foreach($answersA as $answer) {
            $answerId = $answer -> id;
            $questions[] = DB::table('questions') -> where('id', $answerId) -> limit(1) -> first();
        }
        return view('exam.examvalidation', compact('questions', 'answersA'));
    }
}
