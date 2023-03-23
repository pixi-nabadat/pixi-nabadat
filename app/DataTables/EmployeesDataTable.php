<?php

namespace App\DataTables;

use App\Models\Package;
use App\Models\User;
use App\Services\CenterPackageService;
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
            ->orderBy(1)
            ->parameters([
                'dom' => 'Blfrtip',
                'order' => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "responsive" => true,
                "scrollX" => '100%',
            ]);
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name')
                ->title(trans('lang.name')),
            Column::make('email')
                ->title(trans('lang.email'))
                ->searchable(false)
                ->orderable(false),
            Column::make('phone')
                ->title(trans('lang.phone')),
            Column::make('is_active')
                ->title(trans('lang.is_active'))
                ->searchable(false)
                ->orderable(false),
            Column::make('location_id')
                ->title(trans('lang.location_id'))
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
        return 'employees_' . date('YmdHis');
    }

}
