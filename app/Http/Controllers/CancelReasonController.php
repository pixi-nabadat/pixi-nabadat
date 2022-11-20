<?php

namespace App\Http\Controllers;

use App\DataTables\CancelReasonsDataTable;
use App\Http\Requests\CancelReasonRequest;
use App\Http\Resources\CancelReasonsResource;
use App\Services\cancelReasonService;
use Illuminate\Http\Request;

class cancelReasonController extends Controller
{
    public function __construct(private CancelReasonService $cancelReasonService)
    {
    }

    
    public function index(CancelReasonsDataTable $dataTable)
    {
        return $dataTable->render('dashboard.cancelReasons.index');
    } //end of index

    public function getAllCancelReasons()
    {
        try{
            $allCancelReasons = $this->cancelReasonService->getAll();
            return cancelReasonsResource::collection($allCancelReasons);
        }
        catch(\Exception $exception){
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }
    
    public function edit($id)
    {
        $cancelReason = $this->cancelReasonService->find($id);
        if (!$cancelReason) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.cancelReason_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.cancelReasons.edit', compact('cancelReason'));
    } //end of edit

    public function create()
    {
        return view('dashboard.cancelReasons.create');
    } //end of create

    public function store(CancelReasonRequest $request)
    {
        try {
            $this->cancelReasonService->store($request->validated());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'cancelReason Saved Successfully'];
            return redirect()->route('cancelReasons.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of store

    public function update(cancelReasonRequest $request, $id)
    {
        try {
            $this->cancelReasonService->update($id, $request->validated());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('cancelReasons.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy($id)
    {
        try {
            $result = $this->cancelReasonService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        $cancelReason = $this->cancelReasonService->find($id);
        if (!$cancelReason) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.cancelReason_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.cancelReasons.show', compact('cancelReason'));
    } //end of show

    public function changeStatus(Request $request)
    {
        try {
            $result =  $this->cancelReasonService->changeStatus($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of changeStatus
}
