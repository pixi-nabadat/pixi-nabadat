<?php

namespace App\DataTables;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CouponsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(Coupon $coupon){
            return view('dashboard.Coupons.action',compact('coupon'))->render();
        })
        ->editColumn('added_by', function(Coupon $coupon){
            return  $coupon->user->name ;
        })
        ->addcolumn('discount', function(Coupon $coupon){
            return $coupon->discount ;
        })
        ->addcolumn('start_date', function(Coupon $coupon){
            return $coupon->start_date ;
        })
        ->addcolumn('end_date', function(Coupon $coupon){
            return $coupon->end_date ;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CouponsDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Coupon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('Couponsdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('code'),
            Column::make('added_by'),
            Column::make('discount'),
            Column::make('start_date'),
            Column::make('end_date'),
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
        return 'Coupons_' . date('YmdHis');
    }

}
