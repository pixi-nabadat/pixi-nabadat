<?php

namespace App\Http\Controllers;

use App\DataTables\CancelReasonsDataTable;
use App\Http\Requests\CancelReasonRequest;
use App\Services\CancelReasonService;
use Illuminate\Http\Request;

class CancelReasonController extends Controller
{
    public function __construct(private CancelReasonService $cancelReasonService)
    {
    }

    public function index(CancelReasonsDataTable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_cancel_reason');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>[]])->render('dashboard.cancelReasons.index');
    } //end of index


    public function edit(Request $request, $id)
    {
        userCan(request: $request, permission: 'edit_cancel_reason');
        $cancelReason = $this->cancelReasonService->find($id);
        if (!$cancelReason) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.cancel_reason_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.cancelReasons.edit', compact('cancelReason'));
    } //end of edit

    public function create(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        userCan(request: $request, permission: 'create_cancel_reason');
        return view('dashboard.cancelReasons.create');
    } //end of create

    public function store(CancelReasonRequest $request): \Illuminate\Http\RedirectResponse
    {
        userCan(request: $request, permission: 'create_cancel_reason');
        try {
            $this->cancelReasonService->store($request->validated());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect()->route('cancelReasons.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of store

    public function update(cancelReasonRequest $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        userCan(request: $request, permission: 'edit_cancel_reason');
        try {
            $this->cancelReasonService->update($id, $request->validated());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('cancelReasons.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy(Request $request, $id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        userCan(request: $request, permission: 'delete_cancel_reason');
        try {
            $result = $this->cancelReasonService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show(Request $request, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        userCan(request: $request, permission: 'view_cancel_reason');
        $cancelReason = $this->cancelReasonService->find($id);
        if (!$cancelReason) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.cancel_reason_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.cancelReasons.show', compact('cancelReason'));
    } //end of show

    public function changeStatus(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $result = $this->cancelReasonService->changeStatus($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of changeStatus
}
