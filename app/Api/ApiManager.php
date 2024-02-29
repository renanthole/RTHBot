<?php

namespace App\Api;

use App\Models\Chat;
use App\Models\Message;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApiManager
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    protected function buildApiUrl($endpoint, $instanceId, $apiToken)
    {
        $url = $this->config['url'] . '/' . str_replace(['{instance_id}', '{api_token}', '{endpoint}'], [$instanceId, $apiToken, $endpoint], $this->config['endpoint_template']);

        return $url;
    }

    public function getDeviceStatus($instanceId, $apiToken)
    {
        $url = $this->buildApiUrl('status', $instanceId, $apiToken);

        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                return json_decode($response->body());
            } else {
                return 'Erro na requisição: ' . $response->status();
            }
        } catch (Exception $e) {
            return 'Erro na requisição: ' . $e->getMessage();
        }
    }

    public function getQrCodeImage($instanceId, $apiToken)
    {
        $url = $this->buildApiUrl('qr-code/image', $instanceId, $apiToken);

        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                return json_decode($response->body());
            } else {
                return 'Erro na requisição: ' . $response->status();
            }
        } catch (Exception $e) {
            return 'Erro na requisição: ' . $e->getMessage();
        }
    }

    public function getDisconnect($instanceId, $apiToken)
    {
        $url = $this->buildApiUrl('disconnect', $instanceId, $apiToken);

        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                return json_decode($response->body());
            } else {
                return 'Erro na requisição: ' . $response->status();
            }
        } catch (Exception $e) {
            return 'Erro na requisição: ' . $e->getMessage();
        }
    }

    public function sendMessage($message, $phone, $device, $chat)
    {
        $url = $this->buildApiUrl('send-text', $device->instancia, $device->token);

        try {
            $response = Http::timeout(10)->post($url, ['phone' => $phone, 'message' => $message]);

            if ($response->successful()) {
                $response = json_decode($response->body());

                Message::create([
                    'chat_id' => $chat->id,
                    'message_id' => $response->messageId,
                    'type' => 'DeliveryCallback',
                    'message' => $message,
                    'status' => 'DELIVERED',
                    'created_at' => now()
                ]);
                
                return $response;
            } else {
                return 'Erro na requisição: ' . $response->status();
            }
        } catch (Exception $e) {
            return 'Erro na requisição: ' . $e->getMessage();
        }
    }

    public function readMessages()
    {
        // Lógica para ler mensagens da API
    }

    // Outros métodos para interagir com a API
}
