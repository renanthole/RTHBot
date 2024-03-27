<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('chats')->name('chats.')->group(function () {
        Route::get('/', [App\Http\Controllers\ChatController::class, 'index'])->name('index');
        Route::get('/{chat}', [App\Http\Controllers\ChatController::class, 'show'])->name('show');
        Route::get('/new', [App\Http\Controllers\ChatController::class, 'create'])->name('create');
        Route::post('/new', [App\Http\Controllers\ChatController::class, 'store'])->name('store');
        Route::get('/edit/{chat}', [App\Http\Controllers\ChatController::class, 'edit'])->name('edit');
        Route::put('/edit/{chat}', [App\Http\Controllers\ChatController::class, 'update'])->name('update');
        Route::delete('/delete/{chat}', [App\Http\Controllers\ChatController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('devices')->name('devices.')->group(function () {
        Route::get('/', [App\Http\Controllers\DeviceController::class, 'index'])->name('index');
        Route::get('/new', [App\Http\Controllers\DeviceController::class, 'create'])->name('create');
        Route::post('/new', [App\Http\Controllers\DeviceController::class, 'store'])->name('store');
        Route::get('/edit/{device}', [App\Http\Controllers\DeviceController::class, 'edit'])->name('edit');
        Route::put('/edit/{device}', [App\Http\Controllers\DeviceController::class, 'update'])->name('update');
        Route::delete('/delete/{device}', [App\Http\Controllers\DeviceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [App\Http\Controllers\QuizController::class, 'index'])->name('index');
        Route::get('/new', [App\Http\Controllers\QuizController::class, 'create'])->name('create');
        Route::post('/new', [App\Http\Controllers\QuizController::class, 'store'])->name('store');
        Route::get('/edit/{quiz}', [App\Http\Controllers\QuizController::class, 'edit'])->name('edit');
        Route::put('/edit/{quiz}', [App\Http\Controllers\QuizController::class, 'update'])->name('update');
        Route::delete('/delete/{quiz}', [App\Http\Controllers\QuizController::class, 'destroy'])->name('destroy');

        Route::get('/send/{quiz}', [App\Http\Controllers\QuizController::class, 'send'])->name('send');
        Route::post('/send/{quiz}', [App\Http\Controllers\QuizController::class, 'sendStore'])->name('sendStore');
    });

    Route::prefix('quizzes/{quiz}/questions')->name('questions.')->group(function () {
        Route::get('/', [App\Http\Controllers\QuestionController::class, 'index'])->name('index');
        Route::get('/new', [App\Http\Controllers\QuestionController::class, 'create'])->name('create');
        Route::post('/new', [App\Http\Controllers\QuestionController::class, 'store'])->name('store');
        Route::get('/edit/{question}', [App\Http\Controllers\QuestionController::class, 'edit'])->name('edit');
        Route::put('/edit/{question}', [App\Http\Controllers\QuestionController::class, 'update'])->name('update');
        Route::delete('/delete/{question}', [App\Http\Controllers\QuestionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('quizzes/{quiz}/questions/answers')->name('answers.')->group(function () {
        Route::get('/', [App\Http\Controllers\AnswerController::class, 'index'])->name('index');
        Route::get('/new', [App\Http\Controllers\AnswerController::class, 'create'])->name('create');
        Route::post('/new', [App\Http\Controllers\AnswerController::class, 'store'])->name('store');
        Route::get('/edit/{answer}', [App\Http\Controllers\AnswerController::class, 'edit'])->name('edit');
        Route::put('/edit/{answer}', [App\Http\Controllers\AnswerController::class, 'update'])->name('update');
        Route::delete('/delete/{answer}', [App\Http\Controllers\AnswerController::class, 'destroy'])->name('destroy');
    });
});
