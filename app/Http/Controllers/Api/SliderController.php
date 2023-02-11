<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlidersResource;
use App\Services\SliderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private SliderService $sliderService)
    {
    }

    public function listing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = $request->all();
            $filters['is_active'] = 1;
            $filters['start_date'] = Carbon::now(config('app.africa_timezone'));
            $filters['end_date'] = Carbon::now(config('app.africa_timezone'));
            $withRelation = ['center'];
            $result = $this->sliderService->getAll($filters,$withRelation);
            $sliders =  SlidersResource::collection($result);
            return apiResponse(data: $sliders, message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: $e->getCode());
        }
    }
}
