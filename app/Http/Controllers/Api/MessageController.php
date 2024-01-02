<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sent(Request $request)
    {
        $message = $request->text['message'];
        $phone = $request->phone;
        $status = $request->status;
        $zaapId = $request->zaapId;

        $chat = Chat::firstOrCreate(
            [
                'phone' => $phone,
                'zaap_id' => $zaapId
            ],
            [
                'finished_at' => null
            ]
        );

        if ($chat) {
            Message::create([
                'chat_id' => $chat->id,
                'type' => 'DeliveryCallback',
                'message' => $message,
                'status' => $status,
                'created_at' => now()
            ]);

            return true;
        }
    }

    public function received(Request $request)
    {
        $message = $request->text['message'];
        $phone = $request->phone;
        $status = $request->status;
        $messageId = $request->messageId;

        $chat = Chat::firstOrCreate(
            ['phone' => $phone],
            ['finished_at' => null]
        );

        if ($chat) {
            Message::create([
                'chat_id' => $chat->id,
                'message_id' => $messageId,
                'type' => 'ReceivedCallback',
                'message' => $message,
                'status' => $status,
                'created_at' => now()
            ]);

            if (str_contains($message, '123')) {
                return response()->json('Mensagem 123');
            } else {
                return response()->json('Outra mensagem');
            }
        }
    }
}
