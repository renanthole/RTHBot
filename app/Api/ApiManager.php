<?php

namespace App\Api;

use Exception;
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

    public function sendMessage($message, $phone, $instanceId, $apiToken)
    {
        $url = $this->buildApiUrl('send-text', $instanceId, $apiToken);

        try {
            $response = Http::timeout(10)->post($url, ['phone' => $phone, 'message' => $message]);

            if ($response->successful()) {
                return json_decode($response->body());
            } else {
                return 'Erro na requisição: ' . $response->status();
            }
        } catch (Exception $e) {
            dd('erro');
            return 'Erro na requisição: ' . $e->getMessage();
        }
    }

    public function readMessages()
    {
        // Lógica para ler mensagens da API
    }

    // Outros métodos para interagir com a API
}
