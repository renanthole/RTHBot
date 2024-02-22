<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiManager;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Device;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new ApiManager(config('z-api'));
    }

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

            $device = Device::find(1);

            if (str_contains($message, '123')) {
                // $this->apiManager->sendMessage("Você enviou uma mensagem contendo o texto 'Mensagem 123'", $phone, $device->instancia, $device->token);
                // return response()->json('Mensagem 123');
                return true;
            } else {
                // $this->apiManager->sendMessage("Você enviou uma mensagem que não contem o texto 'Mensagem 123'", $phone, $device->instancia, $device->token);
                // return response()->json('Outra mensagem');
                return true;
            }
        }
    }
}
