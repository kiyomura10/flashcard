<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

//Route::get('question',function(){return view('question');});
Route::middleware('auth')->group(function(){
    Route::get('/questionindex',[QuestionController::class,'index'])->name('index');
    Route::get('/questionregister',[QuestionController::class, 'create']);
    Route::post('/questionregister',[QuestionController::class, 'store'])->name('questionregister');
    Route::get('/questionshow/{id}',[QuestionController::class, 'show'])->name('show');
    Route::get('/questionedit/{id}/edit',[QuestionController::class, 'edit'])->name('edit');
    Route::patch('/questionedit/{question_id}',[QuestionController::class, 'update'])->name('patch');
    Route::delete('questiondelete/{question_id}',[QuestionController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function(){
    Route::get('learn',[LearnController::class,'index'])->name('learn.index');
    Route::get('learnshow',[LearnController::class,'show'])->name('learn.show');
    Route::post('learnajax',[LearnController::class,'learnAjax'])->name('learnajax');
    Route::get('/dashboard', [LearnController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
});

Route::middleware('auth')->group(function(){
    Route::get('/tag',[TagController::class,'index'])->name('tag.index');
    Route::post('/tag',[TagController::class,'store'])->name('tag.store');
    Route::delete('/tag',[TagController::class,'destroy'])->name('tag.destroy');
    Route::post('tagajax',[TagController::class,'tagAjax'])->name('tagajax');
    Route::get('tagindexajax',[TagController::class,'tagIndexAjax'])->name('tagindexajax');
    Route::post('/questionedit/{id}/tagajax',[TagController::class,'tagAjax']);
    Route::get('/questionedit/{id}/tagindexajax',[TagController::class,'tagIndexAjax']);
    Route::get('/questionedit/{id}/tageditajax',[TagController::class,'tagEditAjax']);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
