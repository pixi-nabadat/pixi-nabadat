<?php

namespace App\DataTables;

use App\Models\centerDevice;
use App\Services\CenterDeviceService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CenterDeviceDataTable extends DataTable
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
            ->addColumn('action', function (CenterDevice $centerDevice) {
                return view('dashboard.centerDevices.action', compact('centerDevice'))->render();
            })
            ->editColumn('center', function (CenterDevice $centerDevice) {
                return $centerDevice->center->name;
            })
            ->editColumn('device', function (CenterDevice $centerDevice) {
                return $centerDevice->device->name;
            });

    }

    /**
     * @param CenterDevice $model
     * @return QueryBuilder
     */
    public function query(CenterDeviceService $centerDeviceService): QueryBuilder
    {
        return $centerDeviceService->queryGet($this->filters, $this->withRelations);
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {

            return $this->builder()
            ->setTableId('centerDevicesdatatable-table')
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
            Column::make('center'),
            Column::make('device'),
            Column::make('number_of_devices'),
            Column::make('regular_price'),
            Column::make('nabadat_app_price'),
            Column::make('auto_service_price'),
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
        return 'CenterDevice_' . date('YmdHis');
    }

}