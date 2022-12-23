<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatesStoreRequest;
use App\Services\RatesService;
use Exception;

class RatesController extends Controller
{
    public function __construct(private RatesService $ratesService)
    {

    }

    public function store(RatesStoreRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $data = $request->validated();//contain user_id, item_type, item_id, rate, status, comment
            $status = $this->ratesService->store(data: $data);
            if ($status)
                return apiResponse(message: trans('lang.rate_sent_successfully'), code: 200);
            return apiResponse(message: trans('lang.error_has_occurred'), code: 422);

        } catch (Exception $e) {
            return apiResponse(message: "Something went wrong", code: 422);
        }
    }

    public function destroy($id)
    {
        try {
            $status = $this->ratesService->destroy($id);
            if ($status)
                return apiResponse(message: trans('lang.rate_deleted_successfully'));
            return apiResponse(message: "Something went wrong", code: 422);

        } catch (Exception $e) {
            return apiResponse(message: "Something went wrong", code: 422);
        }
    }
}
