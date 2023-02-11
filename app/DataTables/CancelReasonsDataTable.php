<?php

namespace App\DataTables;

use App\Models\CancelReason;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CancelReasonsDataTable extends DataTable
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
            ->addColumn('action', function (CancelReason $cancelReason) {
                return view('dashboard.cancelReasons.action', compact('cancelReason'))->render();
            })
            ->addcolumn('reason', function (CancelReason $cancelReason) {
                return $cancelReason->reason;
            })
            ->editColumn('created_at', function (CancelReason $cancelReason) {
                return $cancelReason->created_at->format('Y-m-d h:i a');
            })
            ->addcolumn('is_active', function (CancelReason $cancelReason) {
                return view('dashboard.components.switch-btn', ['model' => $cancelReason, 'url' => route('cancelReasons.changeStatus')]);
            })->rawColumns(['action', 'is_active']);
    }

    /**
     * @param CancelReason $model
     * @return QueryBuilder
     */
    public function query(CancelReason $model): QueryBuilder
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
            ->setTableId('cancelReasonsdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            Column::make('reason')
                ->title(trans('lang.reason')),
            Column::make('created_at')
                ->title(trans('lang.created_at')),
            Column::computed('is_active')
                ->title(trans('lang.status')),
            Column::computed('action')
                ->title(trans('lang.action'))
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
        return 'cancelReasons_' . date('YmdHis');
    }

}
