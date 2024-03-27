<?php

namespace App\Console\Commands;

use App\Api\ApiManager;
use App\Models\Chat;
use App\Models\DefaultMessage;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FinishChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $chats = Chat::where('finished_at', null)->whereDoesntHave('messages', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subMinutes(15))->where('status', 'RECEIVED');
        })->get();

        foreach ($chats as $chat) {
            try {
                DB::beginTransaction();

                $chat->update(['finished_at' => now(), 'updated_at' => now()]);

                $disconnectMessage = DefaultMessage::find(1);

                $apiManager = new ApiManager(config('z-api'));
                $apiManager->sendMessage($disconnectMessage->message, $chat->phone, $chat->device, $chat);

                DB::commit();
                return 0;
            } catch (Exception $e) {
                logger($e->getMessage());
                DB::rollBack();
                return 0;
            }
        }
        return 0;
    }
}
