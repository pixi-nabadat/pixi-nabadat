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

    public function index(CancelReasonsDataTable $dataTable)
    {
        return $dataTable->render('dashboard.cancelReasons.index');
    } //end of index


    public function edit($id)
    {
        $cancelReason = $this->cancelReasonService->find($id);
        if (!$cancelReason) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.cancel_reason_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.cancelReasons.edit', compact('cancelReason'));
    } //end of edit

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('dashboard.cancelReasons.create');
    } //end of create

    public function store(CancelReasonRequest $request): \Illuminate\Http\RedirectResponse
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

    public function update(cancelReasonRequest $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
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

    public function destroy($id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
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

    public function show($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
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
