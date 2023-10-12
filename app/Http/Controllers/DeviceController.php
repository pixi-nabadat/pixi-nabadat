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

    public function index(DevicesDataTable $dataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('dashboard.devices.index');

    }//end of index

    public function edit($id){
        $withRelation = ['attachments'];
        $device = $this->deviceService->find($id,$withRelation);
        if (!$device)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.device_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.devices.edit', compact('device'));
    }//end of index

    public function create(){
        return view('dashboard.devices.create');
    }//end of index

    public function update(DeviceRequest $request, $id)
    {
        try {

            $this->deviceService->update($id,$request->validated());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('devices.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return back()->with('toast', $toast);
        }
    } //end of update

    public function store(DeviceRequest $request){
        try {
            $this->deviceService->store($request->validated());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect()->route('devices.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return back()->with('toast', $toast);
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
        $withRelation = ['attachments'];
        $device = $this->deviceService->find($id,$withRelation);
        if (!$device)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.device_not_found')];
            return back()->with('toast', $toast);
        }
       return view('dashboard.devices.show', compact('device'));
    } //end of show

    public function changeStatus(Request $request)
    {

        try {
            $result =  $this->deviceService->changeStatus($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of changeStatus
}
