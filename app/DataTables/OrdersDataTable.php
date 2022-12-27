<?php

namespace App\DataTables;

use App\Models\order;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{

    
    
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))

        ->addColumn('action', function(Order $order){
            return view('dashboard.orders.action',compact('order'))->render();
        })
        ->addColumn('ordered_by', function(Order $order){
                return  $order->user->name;
            }) 
        ->addColumn('payment_type', function(Order $order){
            $types = ['PAYMENTCREDIT' , 'PAYMENTCASH'];
            return  $types[$order->payment_type];
        })
        ->addColumn('address_info', function(Order $order){
            return  $order->address_info;
        })    
        ->addColumn('shipping_fees', function(Order $order){
            return  $order->shipping_fees;
        }) 
        ->addColumn('sub_total', function(Order $order){
            return  $order->sub_total;
        }) 
        ->addColumn('grand_total', function(Order $order){
            return  $order->grand_total;
        }) 
        ->addColumn('coupon_discount', function(Order $order){
            return  $order->coupon_discount;
        }) 
        ->addColumn('payment_status', function(Order $order){
            $status = ['Pending' , 'Confirmed', 'Shipped', 'Delivered', 'Canceled'];
            return  $status[$order->payment_status-1];
        }) 
        ->rawColumns(['action','status']);
    }


    public function query(OrderService $OrderService): QueryBuilder
    {
        return $OrderService->queryGet($this->filters,$this->withRelations);
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
            Column::make('ordered_by'),
            Column::make('payment_type'),
            Column::make('address_info'),
            Column::make('shipping_fees'),
            Column::make('sub_total'),
            Column::make('grand_total'),
            Column::make('coupon_discount'),
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
