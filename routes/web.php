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
});
