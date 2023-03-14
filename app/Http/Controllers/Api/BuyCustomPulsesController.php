<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuyCustomPulsesRequest;
use App\Models\UserPackage;
use App\Services\CenterService;
use App\Services\CenterPackageService;
use App\Services\Payment\PaymobService;
use App\Services\UserPackageService;
use App\Services\UserService;
use App\Traits\OrderTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BuyCustomPulsesController extends Controller
{
    use OrderTrait;

    public function __construct(public CenterPackageService  $packageService, protected UserService $userService,
                                protected PaymobService      $paymobService,
                                protected UserPackageService $userPackageService, protected CenterService $centerService)
    {
    }

    //start buy custom pulses

    public function buyCustomPulses(BuyCustomPulsesRequest $request)//: \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            DB::beginTransaction();
            $user = auth('sanctum')->user();
            $user = $user->load('defaultAddress');
            $userAddress = $user->defaultAddress->first();
            if (!isset($userAddress))
                throw new \Exception(trans('user_desnot_have_default_address'));
            //create user package log
            $center = $this->centerService->find($request->center_id);
            $numNabadat = $request->num_nabadat;
            if ($request->payment_method == PaymentMethodEnum::CREDIT) {

                $user_package_data = $this->getUserPackageDataForCustomPulses($numNabadat, $center, $user, PaymentStatusEnum::UNPAID, PaymentMethodEnum::CREDIT, deleted_at: true);

                $user_package = $this->userPackageService->create($user_package_data);

                $order_data = $this->prepareOrderDataForCustomPulses($user, $user_package);

                $order_item_data = $this->prepareOrderItemsDataForcustomPulses($user_package);

                $paymob_order_items = $this->preparePaymobOrderItemsForCustomPulses(user_package_price: $user_package->price);

                $order = $this->setUserOfferAsOrder($user, $order_data, $order_item_data);

                $total_order_amount_in_cents = round(getPriceAfterDiscount($user_package->price, $user_package->discount_percentage) * 100);

                $result = $this->paymobService->payCredit(order_id: $order->id, items: $paymob_order_items, userAddress: $userAddress, total_amount_cents: $total_order_amount_in_cents);

//                if (!$result['status'])
//                    return apiResponse(message: trans('lang.there_is_an_error'), code: 422);

                $status_code = 200 ;
                $message = null;
                $result_data = $result['data'] ?? null;
            } else {
                $user_package_data = $this->getUserPackageDataForCustomPulses($numNabadat, $center, $user);

                $user_package = $this->userPackageService->create($user_package_data);

                $result = $this->userService->updateOrCreateNabadatWallet($user, $user_package);

                $status_code = 422;

                $message = trans('lang.there_is_an_error');

                $result_data = null;

                if ($result) {
                    $status_code = 200;
                    $message = trans('lang.operation_success_please_paid_to-add_pulses_to_your-wallet');
                }
            }
            if ($status_code == 200)
                DB::commit();
            return apiResponse(data: $result_data, message: $message, code: $status_code);
        } catch (\Exception|NotFoundException $exception) {
            return apiResponse(message: $exception, code: 422);
        }
    } //end of index

    private function prepareOrderDataForCustomPulses($user, UserPackage $userPackage): array
    {
        return [
            'payment_status' => PaymentStatusEnum::UNPAID,
            'payment_method' => PaymentMethodEnum::CREDIT,
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

    private function prepareOrderItemsDataForcustomPulses(UserPackage $userPackage): array
    {
        return [
            'quantity' => 1,
            'price' => $userPackage->price,
            'discount' => $userPackage->discount_percentage
        ];
    }

    private function preparePaymobOrderItemsForCustomPulses($user_package_price): array
    {
        $order_items[] = [
            "name" => 'buying custom pulses',
            "amount_cents" => $user_package_price * 100,
            "description" => 'number of pulses from center in app',
            "quantity" => 1
        ];
        return $order_items;
    }


    private function getUserPackageDataForCustomPulses(int $num_nabadat, $center, $user, $payment_status = PaymentStatusEnum::UNPAID, $payment_method = PaymentMethodEnum::CASH, $deleted_at = null)
    {
        $active_user_package = $user->package()->where('status', UserPackageStatusEnum::ONGOING)->where('payment_status', PaymentStatusEnum::PAID)->count();

        return [
            'package_id' => null,
            'user_id' => $user->id,
            'num_nabadat' => $num_nabadat,
            'price' => $num_nabadat * $center->pulse_price,
            'center_id' => $center->id,
            'discount_percentage' => $center->pulse_discount,
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
            'status' => $active_user_package > 0 ? UserPackageStatusEnum::PENDING : UserPackageStatusEnum::ONGOING,
            'used_amount' => 0,
            'remain' => $num_nabadat,
            'deleted_at' => isset($deleted_at) ? Carbon::now() : null
        ];
    }
    //end buy custom pulses
}
