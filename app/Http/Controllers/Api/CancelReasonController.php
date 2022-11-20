<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CancelReasonsResource;
use App\Services\CancelReasonService;

class CancelReasonController extends Controller
{
    public function __construct(private CancelReasonService $cancelReasonService)
    {
    }


    public function listing(): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = ['is_active' => 1];
            $allCancelReasons = $this->cancelReasonService->getAll(where_condition: $filters);
            return CancelReasonsResource::collection($allCancelReasons);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

}
