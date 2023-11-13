<?php

namespace App\DataTables;

use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
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
            ->addColumn('action', function (Coupon $coupon) {
                return view('dashboard.coupons.action', compact('coupon'))->render();
            })
            ->editColumn('added_by', function (Coupon $coupon) {
                return $coupon->creator->name;
            })
            ->editColumn('discount', function (Coupon $coupon) {
                return $coupon->discount . '%';
            })
            ->editColumn('min_buy', function (Coupon $coupon) {
                return $coupon->min_buy . " L.E";
            })
            ->editColumn('allowed_usage', function (Coupon $coupon) {
                return $coupon->allowed_usage;
            })
            ->editColumn('coupon_for', function (Coupon $coupon) {
                return $coupon->coupon_for;
            })
            ->editColumn('start_date', function (Coupon $coupon) {
                return $coupon->start_date;
            })
            ->editColumn('end_date', function (Coupon $coupon) {
                return $coupon->end_date;
            })->addColumn('is_active', function (Coupon $coupon) {
                return view('dashboard.components.switch-btn', ['model' => $coupon, 'url' => route('coupons.status')])->render();
            })
            ->rawColumns(['action', 'is_active']);
    }

    /**
     * @param Coupon $model
     * @return QueryBuilder
     */
    public function query(CouponService $couponService): QueryBuilder
    {
        return $couponService->queryGet($this->filters);
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
            Column::make('code')
                ->title(trans('lang.code')),
            Column::make('added_by')
                ->title(trans('lang.added_by')),
            Column::make('discount')
                ->title(trans('lang.discount')),
            Column::make('min_buy')
                ->title(trans('lang.min_buy'))
                ->searchable(false)
                ->orderable(false),
            Column::make('allowed_usage')
                ->title(trans('lang.allowed_usage'))
                ->searchable(false)
                ->orderable(false),
            Column::make('coupon_for')
                ->title(trans('lang.coupon_for'))
                ->searchable(false)
                ->orderable(false),
            Column::make('start_date')
                ->title(trans('lang.start_date'))
                ->searchable(false)
                ->orderable(false),
            Column::make('end_date')
                ->title(trans('lang.end_date'))
                ->searchable(false)
                ->orderable(false),
            Column::make('is_active')
                ->title(trans('lang.is_active'))
                ->searchable(false)
                ->orderable(false),
            Column::computed('action')
                ->title(trans('lang.action'))
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
