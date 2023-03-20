<?php

namespace App\DataTables;

use App\Models\UserPackage;
use App\Services\UserPackageService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserPackagesDatatable extends DataTable
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
                ->title(trans('lang.user')),
            Column::make('center_id')
                ->title(trans('lang.center')),
            Column::make('num_nabadat')
                ->title(trans('lang.num_nabadat'))
                ->searchable(false)
                ->orderable(false),
            Column::make('price')
                ->title(trans('lang.price'))
                ->searchable(false)
                ->orderable(false),
            Column::make('package_id')
                ->title(trans('lang.package'))
                ->searchable(false)
                ->orderable(false),
            Column::make('discount_percentage')
                ->title(trans('lang.discount_percentage'))
                ->searchable(false)
                ->orderable(false),
            Column::make('payment_method')
                ->title(trans('lang.payment_method'))
                ->searchable(false)
                ->orderable(false),
            Column::make('payment_status')
                ->title(trans('lang.payment_status'))
                ->searchable(false)
                ->orderable(false),
            Column::make('status')
                ->title(trans('lang.status'))
                ->searchable(false)
                ->orderable(false),
            Column::make('used')
                ->title(trans('lang.used'))
                ->searchable(false)
                ->orderable(false),
            Column::make('remain')
                ->title(trans('lang.remain'))
                ->searchable(false)
                ->orderable(false),
            Column::computed('action')
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
        return 'Packages_' . date('YmdHis');
    }

}