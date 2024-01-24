<?php

namespace App\Http\Controllers;

use App\Api\ApiManager;
use App\Models\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = Device::paginate(15);

        return view('pages.devices.index', compact(['devices']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.devices.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Device::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'instancia' => $request->instancia,
                'token' => $request->token,
                'created_at' => now()
            ]);

            DB::commit();
            Alert::toast(__('message.success'), 'success');
            return redirect()->route('devices.index');
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('devices.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        return view('pages.devices.edit', compact(['device']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        try {
            DB::beginTransaction();

            $device->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'instancia' => $request->instancia,
                'token' => $request->token,
                'updated_at' => now()
            ]);

            DB::commit();
            Alert::toast(__('message.update'), 'success');
            return redirect()->route('devices.index');
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('devices.edit', $device->id)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        try {
            DB::beginTransaction();

            $device->delete();

            DB::commit();
            Alert::toast(__('message.delete'), 'warning');
            return redirect()->route('devices.index');
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('devices.edit', $device->id)->withInput();
        }
    }
}
