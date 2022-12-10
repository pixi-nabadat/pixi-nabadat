<?php

namespace App\Http\Controllers;

use App\DataTables\centerDeviceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CenterDeviceUpdateRequest;
use App\Http\Requests\CenterDeviceStoreRequest;
use App\Models\Center;
use App\Services\CenterDeviceService;
use App\Services\CenterService;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class CenterDeviceController extends Controller
{
    public function __construct(private CenterDeviceService $centerDeviceService ,private CenterService $centerService,private DeviceService $deviceService)
    {

    }

    public function index(CenterDeviceDataTable $dataTable,Request $request)
    {
        $loadRelation = ['center','device'];
        return $dataTable->with(['filters' => $request->all(), 'withRelations' => $loadRelation])->render('dashboard.centerDevices.index');

    }//end of index

    public function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $centerDevice = $this->centerDeviceService->find($id);
        if (!$centerDevice)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.centerDevice_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.centerDevices.edit', compact('centerDevice'));
    }//end of edit

    public function update(CenterDeviceUpdateRequest $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $this->centerDeviceService->update($id,  $request->validated());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('centerDevices.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return back()->with('toast', $toast);
        }
    } //end of update

}
