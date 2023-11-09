<?php

namespace App\DataTables;

use App\Models\CancelReason;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoicesDataTable extends DataTable
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
            ->addColumn('action', function (Invoice $invoice) {
                return view('dashboard.invoices.action', compact('invoice'))->render();
            })
            ->addcolumn('center', function (Invoice $invoice) {
                return $invoice->center->user->name;
            })
            ->editColumn('created_at', function (Invoice $invoice) {
                return $invoice->created_at->format('Y-m-d h:i a');
            })
            ->editColumn('completed_date', function (Invoice $invoice) {
                return $invoice->completed_date ?? '-';
            })
            ->addcolumn('status', function (Invoice $invoice) {
                return view('dashboard.invoices._status',compact('invoice'));
            })->rawColumns(['action']);
    }

    /**
     * @param CancelReason $model
     * @return QueryBuilder
     */
    public function query(InvoiceService $invoiceService): QueryBuilder
    {
        return $invoiceService->queryGet($this->filters , $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('invoices-table')
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
            Column::make('center')
                ->title(trans('lang.center')),
            Column::make('total_center_dues')
                ->title(trans('lang.center_dues'))
                ->searchable(false)
                ->orderable(false),
            Column::make('total_nabadat_dues')
                ->title(trans('lang.nabadat_dues'))
                ->searchable(false)
                ->orderable(false),
            Column::make('center_cash_dues')
                ->title(trans('lang.center_cash_dues'))
                ->searchable(false)
                ->orderable(false),
            Column::make('center_credit_dues')
                ->title(trans('lang.center_credit_dues'))
                ->searchable(false)
                ->orderable(false),
            Column::make('nabadat_cash_dues')
                ->title(trans('lang.nabadat_cash_dues'))
                ->searchable(false)
                ->orderable(false),
            Column::make('nabadat_credit_dues')
                ->title(trans('lang.nabadat_credit_dues'))
                ->searchable(false)
                ->orderable(false),
            Column::make('completed_date')
                ->title(trans('lang.completed_date')),
            Column::computed('status')
                ->title(trans('lang.status'))
                ->width(60)
                ->addClass('text-center'),
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
        return 'invoices' . date('YmdHis');
    }

}
