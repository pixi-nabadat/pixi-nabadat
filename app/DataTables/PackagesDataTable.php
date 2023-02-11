<?php

namespace App\DataTables;

use App\Models\Package;
use App\Services\PackageService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PackagesDataTable extends DataTable
{

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Package $package) {
                return view('dashboard.packages.action', compact('package'))->render();
            })
            ->editColumn('name', function (Package $package) {
                return $package->name;
            })
            ->addColumn('center_id', function (Package $package) {
                return $package->center->name;
            })
            ->addColumn('center_phone', function (Package $package) {
                return $package->center->phone;
            })
            ->editColumn('status', function (Package $package) {
                return $package->status;
            })
            ->addColumn('is_active', function (Package $package) {
                return view('dashboard.components.switch-btn', ['model' => $package, 'url' => route('packages.status')])->render();
            })
            ->rawColumns(['action', 'is_active']);
    }

    public function query(PackageService $model): QueryBuilder
    {
        return $model->queryGet($this->filters, $this->withRelations);
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('packagesdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name')
            ->title(trans('lang.name')),
            [
                'data' => 'center_id',
                'name' => 'center_id',
                'title' => 'center_name'
            ],
            [
                'name' => 'center_phone',
                'data' => 'center_phone',
                'title' => 'center_phone'
            ],
            Column::make('num_nabadat')
            ->title(trans('lang.num_nabadat')),
            Column::make('price')
            ->title(trans('lang.price')),
            Column::make('start_date')
            ->title(trans('lang.start_date'))
                ->searchable(false)
                ->orderable(false),
            Column::make('end_date')
            ->title(trans('lang.end_date'))
                ->searchable(false)
                ->orderable(false),
            Column::make('discount_percentage')
            ->title(trans('lang.discount_percentage')),
            Column::make('status')
            ->title(trans('lang.status')),
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
        return 'Packages_' . date('YmdHis');
    }

}
