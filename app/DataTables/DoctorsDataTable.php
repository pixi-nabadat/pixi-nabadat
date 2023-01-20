<?php

namespace App\DataTables;

use App\Models\Doctor;
use App\Models\User;
use App\Services\DoctorService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DoctorsDataTable extends DataTable
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
            ->editColumn('name', function (Doctor $doctor) {
                return $doctor->name;
            })
            ->addcolumn('center_name', function (Doctor $doctor) {
                return $doctor->center->user->name;
            })
            ->editColumn('phone', function (Doctor $doctor) {
                return Arr::first($doctor->phones);
            })
            ->addcolumn('is_active', function (Doctor $doctor) {
                return view('dashboard.components.switch-btn', ['model' => $doctor, 'url' => route('doctors.changeStatus')]);
            })
            ->addColumn('action', function (Doctor $doctor) {
                return view('dashboard.doctors.action', compact('doctor'))->render();
            })
            ->rawColumns(['action', 'is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DoctorService $doctorService): QueryBuilder
    {
        return $doctorService->queryGet($this->filters, $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('doctorsdatatable-table')
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

            Column::make('name')
                ->title(trans('lang.name')),
            Column::make('center_name')
                ->title(trans('lang.center')),
            Column::make('phone')
                ->title(trans('lang.phone')),
            Column::make('age')
                ->title(trans('lang.age'))
                ->searchable(false)
                ->orderable(false),
            Column::make('description')
                ->title(trans('lang.description'))
                ->searchable(false)
                ->orderable(false),
            Column::computed('is_active')
                ->exportable(false)
                ->printable(false),
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
        return 'Doctors_' . date('YmdHis');
    }
}
