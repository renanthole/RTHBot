<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sent', [App\Http\Controllers\Api\MessageController::class, 'sent']);
Route::post('/received', [App\Http\Controllers\Api\MessageController::class, 'received']);

Route::prefix('whatsapp')->group(function () {
    Route::get('/status/{device}', [App\Http\Controllers\Api\WhatsappController::class, 'statusDevice']);
    Route::get('/qrcode/{device}', [App\Http\Controllers\Api\WhatsappController::class, 'qrCodeImage']);
    Route::post('/disconnect/{device}', [App\Http\Controllers\Api\WhatsappController::class, 'disconnect']);
});
