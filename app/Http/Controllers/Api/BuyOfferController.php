<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuyOfferRequest;
use App\Services\PackageService;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

class BuyOfferController extends Controller
{
    public function __construct(protected PackageService $packageService, protected UserService $userService)
    {
    }

    public function buyOffer(BuyOfferRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            DB::beginTransaction();
            $package = $this->packageService->find($request->package_id);
            if (!$package)
                return apiResponse(message: trans('lang.resource_not_found'), code: 422);
            //create user package log
            $userPackageData = ['package_id'=>$package->id,'num_pulses'=>$package->num_nabadat,'price'=>$package->price];
            $this->userService->userPackage(user_id: $request->user_id,date: $userPackageData);
            $updatedWallet = $this->userService->updateOrCreateNabadatWallet(user_id: $request->user_id, package: $package);
            if (!$updatedWallet)
                return apiResponse(message: trans('lang.user_not_found'), code: 422);
            DB::commit();
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of index
}
