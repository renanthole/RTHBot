<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiManager;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Chat;
use App\Models\Device;
use App\Models\Message;
use App\Models\Question;
use App\Models\Quiz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function received(Request $request, ApiManager $apiManager)
    {
        DB::beginTransaction();

        try {
            $message = $request->text['message'];
            $phone = $request->phone;
            $status = $request->status;
            $messageId = $request->messageId;
            $device = Device::where('phone', $request->connectedPhone)->first();
            $quiz = Quiz::where('initial', 1)->first();

            $chat = Chat::firstOrCreate(
                ['device_id' => $device->id, 'phone' => $phone, 'finished_at' => null],
                ['quiz_id' => $quiz->id]
            );

            if ($chat) {
                $this->processReceivedMessage($chat, $messageId, $message, $status, $phone, $device, $apiManager);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return response()->json('Error: ' . $e->getMessage() . '. Line: ' . $e->getLine(), 500);
        }
    }

    private function processReceivedMessage($chat, $messageId, $message, $status, $phone, $device, $apiManager)
    {
        $quiz = Quiz::findOrFail($chat->quiz_id);

        Message::create([
            'chat_id' => $chat->id,
            'message_id' => $messageId,
            'type' => 'ReceivedCallback',
            'message' => $message,
            'status' => $status,
            'created_at' => now()
        ]);

        if ($chat->wasRecentlyCreated) {
            $this->sendFirstQuestion($chat, $phone, $device, $apiManager);
        } else {
            $this->processFollowUpQuestion($chat, $phone, $device, $apiManager);
        }
    }

    private function sendFirstQuestion($chat, $phone, $device, $apiManager)
    {
        $question = Question::where('quiz_id', $chat->quiz_id)->where('position', 1)->first();
        $apiManager->sendMessage($question->question, $phone, $device, $chat);
    }

    private function processFollowUpQuestion($chat, $phone, $device, $apiManager)
    {
        $lastMessageReceived = Message::where('chat_id', $chat->id)->where('status', 'RECEIVED')->latest()->first();
        $lastMessageDelivered = Message::where('chat_id', $chat->id)->where('status', 'DELIVERED')->where('message', '<>', 'Opção inválida')->latest()->first();

        $lastQuestionDelivered = Question::where('question', $lastMessageDelivered->message)->first();
        $awnserQuestion = Answer::where('quiz_id', $chat->quiz_id)->where('question_id', $lastQuestionDelivered->id)->where('option', $lastMessageReceived->message)->first();

        if ($awnserQuestion) {
            if ((bool) $awnserQuestion->free === false) {
                if ($lastMessageReceived->message == $awnserQuestion->option) {
                    $apiManager->sendMessage($awnserQuestion->nextQuestion->question, $phone, $device, $chat);
                }
            } else {
                $apiManager->sendMessage($awnserQuestion->nextQuestion->question, $phone, $device, $chat);
            }
        } else {
            $apiManager->sendMessage('Opção inválida', $phone, $device, $chat);
        }
    }
}
