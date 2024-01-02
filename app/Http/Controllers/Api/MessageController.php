<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function received(Request $request)
    {
        $message = $request->text['message'];
        $phone = $request->phone;

        if (str_contains($message, '123')) {
            return response()->json('Mensagem 123');
        } else {
            return response()->json('Outra mensagem');
        }
    }
}
