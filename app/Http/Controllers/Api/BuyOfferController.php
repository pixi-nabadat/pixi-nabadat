<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuyOfferRequest;
use App\Models\Package;
use App\Models\UserPackage;
use App\Services\CenterPackageService;
use App\Services\CenterService;
use App\Services\Payment\PaymobService;
use App\Services\UserPackageService;
use App\Services\UserService;
use App\Traits\OrderTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BuyOfferController extends Controller
{
    use OrderTrait;

    public function __construct(public CenterPackageService  $packageService, protected UserService $userService,
                                protected PaymobService      $paymobService,
                                protected UserPackageService $userPackageService, protected CenterService $centerService)
    {
    }

    /**
     * @param BuyOfferRequest $request
     * $request has user add bindded it inside validation request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */

    public function buyOffer(BuyOfferRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = auth('sanctum')->user();
            $user = $user->load('defaultAddress');
            $userAddress = $user->defaultAddress->first();
            if (!isset($userAddress)) {
                throw new NotFoundException(trans('please set your address before compeleting the purchase'));
            }
            $withRelation = ['center'];
            $package = $this->packageService->find($request->offer_id, $withRelation);
            //create user package log
            if ($request->payment_method == PaymentMethodEnum::CREDIT) {

                $user_package_data = $this->getUserPackageDataForBuyOffer($package, $user, PaymentStatusEnum::UNPAID, PaymentMethodEnum::CREDIT);

                $userPackage = $this->userPackageService->create($user_package_data);

                $order_data = $this->prepareOrderData($user, $userPackage);

                $order_item_data = $this->prepareOrderItemsData($userPackage);

                $paymob_order_items = $this->preparePaymobOrderItems(name: $package->name, price: $userPackage->price);

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

                $user_package_data = $this->getUserPackageDataForBuyOffer($package, $user);

                $userPackage = $this->userPackageService->create($user_package_data);

                // $result = $this->userService->updateOrCreateNabadatWallet($user, $userPackage);

                $status_code = 422;

                $message = trans('lang.there_is_an_error');

                $result_data = null;

                if ($userPackage) {
                    $status_code = 200;
                    $message = trans('lang.operation_success_please_paid_to_add_pulses_to_your_wallet');
                }
            }
            if ($status_code == 200)
                DB::commit();
            return apiResponse(data: $result_data, message: $message, code: $status_code);
        } catch (NotFoundException|\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of index

    private function prepareOrderData($user, UserPackage $userPackage): array
    {
        return [
            'payment_status' => $userPackage->payment_status,
            'payment_method' => $userPackage->payment_method,
            'address_info' => $user->defaultAddress->toJson(),
            'shipping_fees' => 0,
            'sub_total' => $userPackage->price,
            'grand_total' => getPriceAfterDiscount($userPackage->price, $userPackage->discount_percentage),
            'coupon_discount' => 0,
            'deleted_at' => Carbon::now(),
            'relatable_id' => $userPackage->id,
            'relatable_type' => get_class($userPackage),
        ];
    }

    private function prepareOrderItemsData(UserPackage $userPackage): array
    {
        return [
            'quantity' => 1,
            'price' => $userPackage->price,
            'discount' => $userPackage->discount_percentage
        ];
    }

    private function preparePaymobOrderItems(string $name, int $price): array
    {
        $order_items[] = [
            "name" => $name,
            "amount_cents" => $price * 100,
            "description" => 'offers number of pulses from nabadata app',
            "quantity" => 1
        ];
        return $order_items;
    }

    //start buy custom pulses

    private function getUserPackageDataForBuyOffer(Package $package, $user, $payment_status = PaymentStatusEnum::UNPAID, $payment_method = PaymentMethodEnum::CASH)
    {
        $active_user_package = $user->package()->where('status', UserPackageStatusEnum::ONGOING)->where('payment_status', PaymentStatusEnum::PAID)->count();
        if (!$active_user_package)
            $status = $payment_status == PaymentStatusEnum::PAID ? UserPackageStatusEnum::ONGOING : UserPackageStatusEnum::PENDING;
        else
            $status = $payment_status == PaymentStatusEnum::PAID ? UserPackageStatusEnum::READYFORUSE : UserPackageStatusEnum::PENDING;

        return [
            'package_id' => $package->id,
            'num_nabadat' => $package->num_nabadat,
            'user_id' => $user->id,
            'price' => $package->price,
            'center_id' => $package->center_id,
            'discount_percentage' => $package->discount_percentage,
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
            'status' => $status,
            'used_amount' => 0,
            'remain' => $package->num_nabadat,
        ];
    }
}
