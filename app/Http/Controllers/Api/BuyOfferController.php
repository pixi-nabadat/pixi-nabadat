<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuyOfferRequest;
use App\Models\Package;
use App\Models\User;
use App\Services\PackageService;
use App\Services\Payment\PaymobService;
use App\Services\UserService;
use App\Traits\OrderTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BuyOfferController extends Controller
{
    use OrderTrait;

    public function __construct(protected PackageService $packageService, protected UserService $userService, protected PaymobService $paymobService)
    {
    }

    /**
     * @param BuyOfferRequest $request
     * $request has user add bindded it inside validation request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */

    public function buyOffer(BuyOfferRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            DB::beginTransaction();
            $user = auth('sanctum')->user();
            $user = $user->load('defaultAddress');
            $userAddress = $user->defaultAddress->first();
            $withRelation = ['center'] ;
            $package = $this->packageService->find($request->offer_id,$withRelation);
            if (!$package)
                return apiResponse(message: trans('lang.offer_not_exits'), code: 422);
            //create user package log
            if ($request->payment_method == PaymentMethodEnum::CREDIT) {
                $order_data = $this->prepareOrderData($user, $package);
                $order_item_data = $this->prepareOrderItemsData($package);
                $paymob_order_items = $this->preparePaymobOrderItems($package);
                $order = $this->setUserOfferAsOrder($user, $order_data, $order_item_data);
                $total_order_amount_in_cents = $package->price_after_discount * 100;
                $result = $this->paymobService->payCredit(order_id: $order->id, items: $paymob_order_items, userAddress: $userAddress, total_amount_cents: $total_order_amount_in_cents);
                $status_code = 422;
                $message = trans('lang.there_is_an_error');
                if ($result['status']) {
                    $status_code = 200;
                    $message = null;
                }
                $result_data = $result['data'] ?? null;
            } else {
                $result = $this->userService->updateOrCreateNabadatWallet($user, $package,payment_status: PaymentStatusEnum::PAID);
                $status_code = 422;
                $message = trans('lang.there_is_an_error');
                $result_data = null;
                if ($result) {
                    $status_code = 200;
                    $message = trans('lang.operation_success');
                }
            }
            if ($status_code == 200)
                DB::commit();
            return apiResponse(data: $result_data, message: $message, code: $status_code);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception, code: 422);
        }
    } //end of index

    private function prepareOrderData($user, Package $package): array
    {
        return [
            'payment_status' => PaymentStatusEnum::UNPAID,
            'payment_method' => PaymentMethodEnum::CREDIT,
            'address_info' => $user->defaultAddress->toJson(),
            'shipping_fees' => 0,
            'sub_total' => $package->price,
            'grand_total' => $package->price_after_discount,
            'coupon_discount' => 0,
            'deleted_at' => Carbon::now(),
            'relatable_id' => $package->id,
            'relatable_type' => get_class($package),
        ];
    }

    private function prepareOrderItemsData(Package $package): array
    {
        return [
            'quantity' => 1,
            'price' => $package->price_after_discount,
            'discount' => $package->center->app_discount
        ];
    }

    private function preparePaymobOrderItems(Package $package): array
    {
        $order_items[] = [
            "name" => $package->name,
            "amount_cents" => $package->price_after_discount * 100,
            "description" => 'offers number of pulses from nabadata app',
            "quantity" => 1
        ];
        return $order_items;
    }

}
