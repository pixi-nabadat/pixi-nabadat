<?php

namespace App\Http\Controllers;

use App\DataTables\ordersDataTable;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function index(OrdersDataTable $dataTable, Request $request)
    {
        $loadRelation = ['orderStatus','user:id,name,phone'];
        return $dataTable->with(['filters' => $request->all(), 'withRelations' => $loadRelation])->render('dashboard.orders.index');

    } //end of index

    public function changePaymentStatus(Request $request)
    {

        $this->orderService->updatePaymentStatus($request);
        $this->orderService->updateOrderHistory($request);

        $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
        return redirect(route('orders.index'))->with('toast', $toast);

    } //end of changePaymentStatus

    public function show($id)
    {
        $order = $this->orderService->find($id);
        if (!$order)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.order_not_found')];
            return back()->with('toast', $toast);
        }
       return view('dashboard.orders.show', compact('order'));
    } //end of show

}
