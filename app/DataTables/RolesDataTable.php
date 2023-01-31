<?php

namespace App\DataTables;

use App\Services\RoleService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RolesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query));
        // ->addColumn('action', function (Role $role) {
        //     return view('dashboard.roles.action', compact('role'))->render();
        // });
    }

    /**
     * @param RoleService $model
     * @return QueryBuilder
     */
    public function query(RoleService $model): QueryBuilder
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
            ->setTableId('role-datatable-table')
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
                ->title('Id')
                ->searchable(true)
                ->orderable(true),
            // Column::make('name')
            //     ->title(trans('lang.name'))
            //     ->searchable(true)
            //     ->orderable(true),
            // Column::computed('action')
            //     ->width(60)
            //     ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'roles' . date('YmdHis');
    }

}
