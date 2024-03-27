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

    public function received(Request $request)
    {
        try {
            DB::beginTransaction();

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
                $quiz = Quiz::where('id', $chat->quiz_id)->first();
                
                Message::create([
                    'chat_id' => $chat->id,
                    'message_id' => $messageId,
                    'type' => 'ReceivedCallback',
                    'message' => $message,
                    'status' => $status,
                    'created_at' => now()
                ]);

                if ($chat->wasRecentlyCreated) {
                    $question = Question::where('quiz_id', $quiz->id)->where('position', 1)->first();
                    $this->apiManager->sendMessage($question->question, $phone, $device, $chat);
                } else {
                    $lastMessageReceived = Message::where('chat_id', $chat->id)->where('status', 'RECEIVED')->latest()->first();
                    $lastMessageDelivered = Message::where('chat_id', $chat->id)->where('status', 'DELIVERED')->where('message', '<>', 'Opção inválida')->latest()->first();

                    $lastQuestionDelivered = Question::where('question', $lastMessageDelivered->message)->first();
                    $awnserQuestion = Answer::where('quiz_id', $quiz->id)->where('question_id', $lastQuestionDelivered->id)->where('option', $lastMessageReceived->message)->first();

                    if ($awnserQuestion) {
                        if ((bool) $awnserQuestion->free === false) {
                            if ($lastMessageReceived->message == $awnserQuestion->option) {
                                $this->apiManager->sendMessage($awnserQuestion->nextQuestion->question, $phone, $device, $chat);
                            }
                        } else {
                            $this->apiManager->sendMessage($awnserQuestion->nextQuestion->question, $phone, $device, $chat);
                        }
                    } else {
                        $this->apiManager->sendMessage('Opção inválida', $phone, $device, $chat);
                    }
                }

                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return response()->json('Error: ' . $e->getMessage() . '. Line: ' . $e->getLine(), 500);
        }
    }
}
