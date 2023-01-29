<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentMethodEnum;
use App\Events\PushEvent;
use App\Events\OrderCreated;
use App\Exceptions\BadRequestHttpException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\FcmMessage;
use App\Models\Order;
use App\Services\AddressService;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\Payment\PaymobService;
use App\Traits\OrderTrait;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use OrderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(protected OrderService $orderService, protected CartService $cartService, protected PaymobService $paymobService)
    {
    }

    public function index(Request $request)
    {
        $filters = array_merge($request->all(), ['user_id' => auth('sanctum')->id()]);
        $relations = ['orderStatus', 'items.product.defaultLogo'];
        $order = $this->orderService->listing($filters, $relations);
        return OrderResource::collection($order);
    }

    public function find(int $id): Application|ResponseFactory|Response
    {
        $withRelations = ['items', 'orderStatus'];
        $order = $this->orderService->find($id, $withRelations);
        return apiResponse(data: new OrderResource($order));
    }

    /**
     * @param OrderStoreRequest $request
     * @return Response|OrderResource|Application|ResponseFactory
     */
    public function store(OrderStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = auth('sanctum')->user();
            //1- get cart data for user
            $orderData = app()->make(CartService::class)->getCart($request->temp_user_id);
            if ($orderData->items->isEmpty())
                throw new BadRequestHttpException(trans('lang.there_is_no-items_to_create_order'),422);

            //2-get address info
            $userAddress = app()->make(AddressService::class)->find(id: $request->address_id, withRelations: ['city:id,title,shipping_cost', 'user:id,name,phone,email']);
            if (!$userAddress)
                throw new NotFoundException(trans('lang.address_not_found'));

            $order = $this->storeOrder($orderData,$userAddress, $user,$request->payment_method); // method store order in trait for multiple usage
            if ($request->payment_method == PaymentMethodEnum::CREDIT) {
                $paymob_order_items = $this->prepareOrderItemsForPaymobOrder($order->items);
                $total_order_amount_in_cents = $order->grand_total * 100;
                $status_code = 422;
                $message = trans('lang.there_is_an_error');
                $result = $this->paymobService->payCredit(order_id: $order->id, items: $paymob_order_items, userAddress: $userAddress, total_amount_cents: $total_order_amount_in_cents);
                if ($result['status']) {
                    $status_code = 200;
                    $message = null;
                    DB::commit();
                    $this->cartService->emptyCart($request->temp_user_id);
                }// check if status true commit transaction and store order in database else order not stored in db
                $result_data = $result['data'] ?? null;
                $result = (object)[
                    'payment_token'  =>$result_data,
                    'payment_method' =>PaymentMethodEnum::CREDIT
                ];
                return apiResponse(data: $result, message: $message, code: $status_code);
            }
            $this->cartService->emptyCart($request->temp_user_id);
            DB::commit();
//            event to fire fcm notification message
            event(new PushEvent($order,FcmMessage::CREATE_NEW_ORDER));
            return new OrderResource($order);
        }
        catch (BadRequestHttpException $exception){
            DB::rollBack();
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
        catch (Exception $e) {
            DB::rollBack();
            return apiResponse(message: trans('lang.there_is_an_error'), code: 422);
        }
    }

    private function prepareOrderItemsForPaymobOrder($items): array
    {
        $order_items = [];
        if (count($items)) {
            foreach ($items as $item) {
                $order_items[] = [
                    "name" => $item->product->name,
                    "amount_cents" => $item->price * 100,
                    "description" => $item->product->description,
                    "quantity" => $item['quantity']
                ];
            }
        }
        return $order_items;
    }

    public function checkPaymobPaymentStatus(Request $request): Response|Application|ResponseFactory
    {
        $result = $this->paymobService->paymentCallback($request);
        if ($result != false) {
            logger('merchant_order_id : ' . $result['merchant_order_id']);
            event(new OrderCreated($result['merchant_order_id']));
            return apiResponse(message: trans('lang.payment_accepted'));
        }
        return apiResponse(message: trans('lang.there_is_an_error_try_again_later'), code: 422);
    }
}

//3|ur66oj38RUSES6pQDftDQNQVur9ZhI2AOKiUcvIj live
//2|kvsGbWaVoPHcqULVeynnP69QSwWfkt0o9pHdFdq3 development