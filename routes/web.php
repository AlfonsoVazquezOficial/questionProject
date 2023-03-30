<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    
    Route::resource('questions', QuestionController::class) -> middleware(['typeTeacher']);
    Route::get('dashboard', function() {
        return redirect(route('welcome'));
    });
    Route::get('questions', [QuestionController::class, 'index']) -> name('dashboard') -> middleware(['typeAdmin']);
    Route::get('exam/subjects', [SubjectController::class, '']) -> name('exam.subjects');
    Route::get('exam', [SubjectController::class, 'index']) -> name('exam.careers');
    Route::get('exam/{career}', [SubjectController::class, 'show']) -> name('exam.subjects');
    Route::get('exam/active/{id_subject}', [SubjectController::class, 'exam']) -> name('exam.exam');
    Route::post('exam/validate', [SubjectController::class,'validateExam']) -> name('exam.validate');
    Route::get('welcome', function () {
        return view("dashboard");
    })->name('welcome');


});
