<?php

namespace App\DataTables;

use App\Models\Package;
use App\Models\UserPackage;
use App\Services\PackageService;
use App\Services\UserPackageService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserPackagesDataTable extends DataTable
{

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (UserPackage $userPackage) {
                return view('dashboard.userPackages.action', compact('userPackage'))->render();
            })
            ->editColumn('user_id', function (UserPackage $userPackage) {
                return $userPackage->user->name;
            })
            ->addColumn('center_id', function (UserPackage $userPackage) {
                return $userPackage->center->name;
            })
            ->addColumn('package_id', function (UserPackage $userPackage) {
                return $userPackage->center->name;
            });
    }

    public function query(UserPackageService $model): QueryBuilder
    {
        return $model->queryGet($this->filters, $this->withRelations);
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('userpackagesdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
    }

    protected function getColumns(): array
    {
        return [
            Column::make('user_id')
                ->title(trans('lang.user'))
                ->searchable(true)
                ->orderable(true),
            Column::make('center_id')
                ->title(trans('lang.center'))
                ->searchable(true)
                ->orderable(true),
            Column::make('num_nabadat')
                ->title(trans('lang.num_nabadat'))
                ->searchable(true)
                ->orderable(true),
            Column::make('price')
                ->title(trans('lang.price'))
                ->searchable(true)
                ->orderable(true),
            Column::make('package_id')
                ->title(trans('lang.package'))
                ->searchable(true)
                ->orderable(true),
            Column::make('discount_percentage')
                ->title(trans('lang.discount_percentage'))
                ->searchable(true)
                ->orderable(true),
            Column::make('payment_method')
                ->title(trans('lang.payment_method'))
                ->searchable(true)
                ->orderable(true),
            Column::make('payment_status')
                ->title(trans('lang.payment_status'))
                ->searchable(true)
                ->orderable(true),
            Column::make('status')
                ->title(trans('lang.status'))
                ->searchable(true)
                ->orderable(true),
            Column::make('used')
                ->title(trans('lang.used'))
                ->searchable(true)
                ->orderable(true),
            Column::make('remain')
                ->title(trans('lang.remain'))
                ->searchable(true)
                ->orderable(true),
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
        return 'Packages_' . date('YmdHis');
    }

}