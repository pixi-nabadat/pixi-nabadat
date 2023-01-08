<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentMethodEnum;
use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
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
        $relations = ['history', 'items'];
        $order = $this->orderService->getAll($filters, $relations);
        return OrderResource::collection($order);
    }

    public function find(int $id): OrderResource
    {
        $withRelations = ['items', 'history'];
        $order = $this->orderService->find($id, $withRelations);
        return new OrderResource($order);
    }

    /**
     * @param OrderStoreRequest $request
     * @return Response|OrderResource|Application|ResponseFactory
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = auth('sanctum')->user();
            $order = $this->storeOrder($request, $user); // method store order in trait for multiple usage
            if (isset($order->status_code) && $order->status_code != 200)
                return apiResponse(message: $order->message, code: $order->status_code);
            if ($request->payment_method == PaymentMethodEnum::CREDIT) {
                $paymob_order_items = $this->prepareOrderItemsForPaymobOrder($order->order->items);
                $total_order_amount_in_cents = $order->order->grand_total * 100;
                $status_code = 422;
                $message = trans('lang.there_is_an_error');
                $result = $this->paymobService->payCredit(order_id: $order->order->id, items: $paymob_order_items, userAddress: $order->userAddress, total_amount_cents: $total_order_amount_in_cents);
                if ($result['status']) {
                    User::setPoints(user: $user, amount: (float)$order->order->grand_total);//this will be the user price not package price
                    $status_code = 200;
                    $message = null;
                    DB::commit();
                    $this->cartService->emptyCart($request->serial_number);
                }// check if status true commit transaction and store order in database else order not stored in db
                $result_data = $result['data'] ?? null;
                return apiResponse(data: $result_data, message: $message, code: $status_code);
            }
            $this->cartService->emptyCart($request->serial_number);
            DB::commit();
            return new OrderResource($order);
        } catch (Exception $e) {
            DB::rollBack();
            return apiResponse(message: $e, code: 422);
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
            logger('merchant_order_id : '.$result['merchant_order_id']);
            event(new OrderCreated($result['merchant_order_id']));
            return apiResponse(message: trans('lang.payment_accepted'));
        }
        return apiResponse(message: trans('lang.there_is_an_error_try_again_later'), code: 422);
    }
}
