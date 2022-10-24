<?php

namespace App\Http\Controllers;

use App\DataTables\DevicesDataTable;
use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct(private DeviceService $deviceService)
    {
        
    }
    
    public function index(DevicesDataTable $dataTable){

        return $dataTable->render('dashboard.Devices.index');

    }//end of index

    public function edit($id){
        $device = $this->deviceService->find($id);
        if (!$device)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.device_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.Devices.edit', compact('device'));
    }//end of index 

    public function create(){
        return view('dashboard.Devices.create');
    }//end of index

    public function update(DeviceRequest $request, $id)
    {
        try {
            $request->validated();
            $this->deviceService->update($id, $request->all());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('devices.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update
    
    public function store(DeviceRequest $request){
        try {
            $request->validated();
            $this->deviceService->store($request->all());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Device Saved Successfully'];
            return redirect()->route('devices.index')->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store

    public function destroy($id)
    {
        try {
            $result = $this->deviceService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        $device = $this->deviceService->find($id);
        if (!$device)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.device_not_found')];
            return back()->with('toast', $toast);
        }
       return view('dashboard.Devices.show', compact('device'));
    } //end of show
}
