<?php

namespace App\DataTables;

use App\Models\Package;
use App\Models\User;
use App\Services\PackageService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeesDataTable extends DataTable
{

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', function (User $employee) {
                return $employee->name;
            })
            ->editColumn('location_id', function (User $employee) {
                return optional($employee->location)->title ??"-";
            })
            ->addColumn('action', function (User $employee) {
                return view('dashboard.employees.action', compact('employee'))->render();
            })
            ->addColumn('is_active', function (User $employee) {
                return view('dashboard.components.switch-btn', ['model' => $employee, 'url' => route('employees.status')])->render();
            })
            ->rawColumns(['action', 'is_active']);
    }

    public function query(UserService $model): QueryBuilder
    {
        $filters = ['type'=> User::EMPLOYEE];
        return $model->queryGet($filters, $this->withRelations);
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('employes-datatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
    }

    protected function getColumns(): array
    {
        return [
            Column::make('id')
                ->title(trans('lang.id'))
                ->searchable(true)
                ->orderable(true),
            Column::make('name')
                ->title(trans('lang.name'))
                ->searchable(true)
                ->orderable(true),
            Column::make('email')
                ->title(trans('lang.email'))
                ->searchable(true)
                ->orderable(true),
            Column::make('user_name')
                ->title(trans('lang.user_name'))
                ->searchable(true)
                ->orderable(true),
            Column::make('phone')
                ->title(trans('lang.phone'))
                ->searchable(true)
                ->orderable(true),
            Column::make('is_active')
                ->title(trans('lang.is_active'))
                ->searchable(true)
                ->orderable(true),
            Column::make('location_id')
                ->title(trans('lang.location_id'))
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
        return 'employees_' . date('YmdHis');
    }

}