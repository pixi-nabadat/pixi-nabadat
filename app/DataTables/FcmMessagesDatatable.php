<?php

namespace App\DataTables;

use App\Models\FcmMessage;
use App\Services\FcmMessageService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FcmMessagesDatatable extends DataTable
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
            ->addColumn('action', function (FcmMessage $fcmMessage) {
                return view('dashboard.marketing.fcm-message.action', compact('fcmMessage'))->render();
            })->rawColumns(['action', 'is_active'])
            ->addColumn('is_active', function (FcmMessage $fcmMessage) {
                return view('dashboard.components.switch-btn', ['model' => $fcmMessage, 'url' => route('fcm-messages.status')])->render();
            })
            ->rawColumns(['action', 'is_active']);
    }

    /**
     * @param FcmMessageService $model
     * @return QueryBuilder
     */
    public function query(FcmMessageService $model): QueryBuilder
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
            ->setTableId('fcm-message-datatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->parameters([
                "responsive" => true,
                "scrollX" => '100%',
            ]);
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
                ->searchable(false)
                ->orderable(false),
            Column::make('fcm_action')
                ->title(trans('lang.fcm_action'))
                ->searchable(false)
                ->orderable(false),
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
        return 'fcm-message' . date('YmdHis');
    }

}