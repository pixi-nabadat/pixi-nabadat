<?php

namespace App\DataTables;

use App\Models\Rate;
use App\Models\User;
use App\Services\RateService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RatesDatatable extends DataTable
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
            ->editColumn('user_id', function (Rate $rate) {
                return $rate->user->name;
            })

            ->editcolumn('ratable_id', function (Rate $rate) {
                return $rate->ratable_type == 'App\Models\CenterDevice' ? $rate->ratable->device->name:$rate->ratable->getTranslation('name', app()->getLocale());
            })
            
            ->editcolumn('status', function (Rate $rate) {
                return view('dashboard.components.switch-btn', ['model' => $rate, 'url' => route('rates.changeStatus')])->render();
            })

            ->addColumn('action', function (Rate $rate) {
                return view('dashboard.rates.action', compact('rate'))->render();
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RateService $rateService): QueryBuilder
    {
        return $rateService->queryGet(filters: $this->filters,withRelation: $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('ratesdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [

            Column::make('user_id')
                ->title(trans('lang.user')),
            Column::make('ratable_id')
                ->title(trans('lang.ratable_name')),
            Column::make('status')
                ->title(trans('lang.status'))
                ->searchable(false)
                ->orderable(false),
            Column::make('comment')
                ->title(trans('lang.comment')),
            Column::make('rate_number')
                ->title(trans('lang.rate_number')),
            Column::computed('action')
                ->title(trans('lang.action'))
                ->exportable(false)
                ->printable(false)
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
        return 'Rates_' . date('YmdHis');
    }
}
