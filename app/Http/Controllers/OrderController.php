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
        try {
            $loadRelation = ['orderStatus', 'user:id,name,phone'];
            return $dataTable->with(['filters' => $request->all(), 'withRelations' => $loadRelation])->render('dashboard.orders.index');
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    } //end of index

    public function updateOrderStatus(Request $request)
    {
        try {
            $this->orderService->updateOrderStatus($request);
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('orders.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    } //end of update order Status 

    public function show($id)
    {
        $loadRelation = ['user:id , name , phone'];
        $order = $this->orderService->find($id);
        if (!$order) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.order_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.orders.show', compact('order'))->with(['withRelations' => $loadRelation]);
    } //end of show

}
