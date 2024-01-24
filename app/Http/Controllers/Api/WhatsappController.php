<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiManager;
use App\Facades\ZApiFacade;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Providers\ZApiServiceProvider;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    /**
     * Return status device in z-api
     */
    public function statusDevice($device)
    {
        $device = Device::find($device);

        if (!$device) {
            abort(404);
        }

        $apiManager = new ApiManager(config('z-api'));
        $status = $apiManager->getDeviceStatus($device->instancia, $device->token);

        if ((bool) $status->connected === true) {
            $device->update([
                'connected' => true,
                'connected_at' => now(),
                'smartphone_connected' => $status->smartphoneConnected,
                'smartphone_connected_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json($status, 200);
    }

    /**
     * Return QRCode Image for device in z-api
     */
    public function qrCodeImage($device)
    {
        $device = Device::find($device);

        if (!$device) {
            abort(404);
        }

        $apiManager = new ApiManager(config('z-api'));
        $qrCodeImage = $apiManager->getQrCodeImage($device->instancia, $device->token);

        return response()->json($qrCodeImage, 200);
    }

    /**
     * Disconnect device in z-api
     */
    public function disconnect($device)
    {
        $device = Device::find($device);

        if (!$device) {
            abort(404);
        }

        $apiManager = new ApiManager(config('z-api'));
        $disconnect = $apiManager->getDisconnect($device->instancia, $device->token);

        $device->update([
            'connected' => false,
            'connected_at' => null,
            'smartphone_connected' => false,
            'smartphone_connected_at' => null,
            'updated_at' => now()
        ]);

        return response()->json($disconnect, 200);
    }
}
