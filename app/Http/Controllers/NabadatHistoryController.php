<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NabadatHistoryStoreRequest;
use App\Services\NabadatHistoryService;
use Exception;
use Illuminate\Http\Request;

class NabadatHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private NabadatHistoryService $nabadatHistoryService)
    {

    }

    public function store(NabadatHistoryStoreRequest $request)
    {
        try{
            $request = $request->validated();
            $data = $this->nabadatHistoryService->store($request);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect()->route('reservations.index')->with('toast', $toast);
        } catch (Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }
}