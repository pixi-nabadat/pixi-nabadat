<?php

namespace App\DataTables;

use App\Models\ScheduleFcm;
use App\Services\ScheduleFcmService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ScheduleFcmDatatable extends DataTable
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
            ->addColumn('action', function (ScheduleFcm $scheduleFcm) {
                return view('dashboard.marketing.schedule-fcm.action', compact('scheduleFcm'))->render();
            })->rawColumns(['action', 'is_active'])
            ->addColumn('is_active', function (ScheduleFcm $scheduleFcm) {
                return view('dashboard.components.switch-btn', ['model' => $scheduleFcm, 'url' => route('schedule-fcm.status')])->render();
            })
            ->rawColumns(['action', 'is_active']);
    }

    /**
     * @param ScheduleFcmService $model
     * @return QueryBuilder
     */
    public function query(ScheduleFcmService $model): QueryBuilder
    {
        return $model->queryGet($this->filters , $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('schedule-fcm-datatable-table')
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
            Column::make('id')
                ->title(trans('lang.id'))
                ->searchable(true)
                ->orderable(true),
            Column::make('title')
                ->title(trans('lang.title'))
                ->searchable(true)
                ->orderable(true),
            Column::make('content')
                ->title(trans('lang.content'))
                ->searchable(true)
                ->orderable(true),
            Column::make('trigger')
                ->title(trans('lang.trigger'))
                ->searchable(true)
                ->orderable(true),
            Column::make('start_date')
                ->title(trans('lang.start_date'))
                ->searchable(false)
                ->orderable(false),
            Column::make('end_date')
                ->title(trans('lang.end_date'))
                ->searchable(true)
                ->orderable(true),
            Column::make('notification_via')
                ->title(trans('lang.notification_via'))
                ->searchable(true)
                ->orderable(true),
            Column::make('is_active')
                ->title(trans('lang.is_active'))
                ->searchable(false)
                ->orderable(false),
            Column::computed('action')
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
        return 'schedule-fcm' . date('YmdHis');
    }

}