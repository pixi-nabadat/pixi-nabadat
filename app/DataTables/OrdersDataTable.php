<?php

namespace App\DataTables;

use App\Models\order;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{


    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->addColumn('action', function (Order $order) {
                return view('dashboard.orders.action', compact('order'))->render();
            })
            ->editColumn('user_name', function (Order $order) {
                return $order->user->name;
            })
            ->addColumn('user_phone', function (Order $order) {
                return $order->user->phone;
            })
            ->editColumn('payment_method', function (Order $order) {
                return trans('lang.'.$order->payment_method);
            })
            ->addColumn('shipping_fees', function (Order $order) {
                return $order->shipping_fees;
            })
            ->addColumn('sub_total', function (Order $order) {
                return $order->sub_total;
            })
            ->addColumn('grand_total', function (Order $order) {
                return $order->grand_total;
            })
            ->addColumn('coupon_discount', function (Order $order) {
                return $order->coupon_discount;
            })
            ->addColumn('payment_status', function (Order $order) {
                return $order->payment_status;
            })
            ->rawColumns(['action', 'status']);
    }


    public function query(OrderService $OrderService): QueryBuilder
    {
        return $OrderService->queryGet($this->filters, $this->withRelations);
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('ordersdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
    }

    protected function getColumns(): array
    {
        return [
            [
                'data'=>'user_name',
                'name'=>'user_name',
                'title'=>'user_name',
            ],
            [
                'data'=>'user.phone',
                'name'=>'user_phone',
                'title'=>'user_phone',
            ],
            Column::make('shipping_fees'),
            Column::make('sub_total'),
            Column::make('grand_total'),
            Column::make('coupon_discount'),
            Column::make('payment_method'),
            Column::make('payment_status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'orders_' . date('YmdHis');
    }

}
