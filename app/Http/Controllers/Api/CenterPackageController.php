<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackagesResource;
use App\Services\packageService;

class CenterPackageController extends Controller
{
    public function __construct(private packageService $packageService)
    {
    }


    public function listing(): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = ['is_active' => 1];
            $allPackages = $this->packageService->getAll(where_condition: $filters);
            return PackagesResource::collection($allPackages);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

}
