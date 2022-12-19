<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\AddressService;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\Payment\paymobService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(protected OrderService $orderService, protected CartService $cartService, protected AddressService $addressService, protected paymobService $paymobService)
    {
    }

    public function index(Request $request)
    {
        $filters = array_merge($request->all(), ['user_id' => auth('auth:sanctum')->id()]);
        $relations = ['history'];
        $order = $this->orderService->getAll($filters, $relations);
        return OrderResource::collection($order);
    }

    public function find(int $id): OrderResource
    {
        $withRelations = ['details', 'history'];
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
            //1- get cart data for user
            $orderData = $this->cartService->getCart($request->serial_number);
            //2-get address info
            $userAddress = $this->addressService->find(id: $request->address_id, withRelations: ['city','user']);
//            check availability stocks of products
            foreach ($orderData->items as $item) {
                if ($item->quantity > $item->product->stock)
                    return apiResponse(message: trans('lang.quantity_is_more_than_stock for :product', $item->product->name));
            }
            $payment_type = $request->payment_type == Order::PAYMENTCREDIT ? Order::PAYMENTCREDIT : Order::PAYMENTCASH;
            $order = $this->orderService->store(user: $user, order_data: $orderData, shipping_address: $userAddress, payment_type: $payment_type);
            if ($request->payment_type == Order::PAYMENTCREDIT) {
                $result = $this->payCredit($order, $userAddress);
                if ($result['status']) // check if status true commit transaction and store order in database else order not stored in db
                    DB::commit();
                return apiResponse(data: $result['data']);
            }
            DB::commit();
            return new OrderResource($order);

        } catch (Exception $e) {
            DB::rollBack();
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function payCredit($order, $userAddress): array
    {
        $items = [];
        $total_amount_in_cents = $order->grand_total * 100;
//        payment process to return iframe for billing ;
        $token = $this->paymobService->getAuthToken();
        foreach ($order->items as $item) {
            $items[] = [
                "name" => $item->product->name,
                "amount_cents" => $item->price * 100,
                "description" => $item->product->description,
                "quantity" => $item['quantity']
            ];
        }
        $itemsData = [
            "auth_token" => $token,
            "delivery_needed" => "false",
            "amount_cents" => $total_amount_in_cents,
            "currency" => "EGP",
            "items" => $items
        ];
        $this->paymobService->createOrder($itemsData);
        $response = $this->paymobService->getPaymentToken($order->id, $token, $total_amount_in_cents, $userAddress);
        if (!$response->successful())
            return ['status' => false, 'data' => collect($response->object())->toArray()];
        if ($response->successful())
            $paymentToken = $response->object()->token;
        return ['status' => true, "data" => config('services.paymob.iframe_url') . "?payment_token={$paymentToken}"];
    }

    public function checkPaymobPaymentStatus(): Response|Application|ResponseFactory
    {
        $result = $this->paymobService->paymentCallback();
        if ($result != false) {
            $order = $this->orderService->find($result['id']);
            $order->update(['payment_status' => 'paid', 'payment_type' => Order::PAYMENTCREDIT, 'paymob_transaction_id' => 1]);
            return apiResponse(message: trans('lang.payment_accepted'));
        }
        return apiResponse(message: trans('lang.payment_accepted'), code: 422);

    }
}
