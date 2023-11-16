<?php

namespace App\DataTables;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('action', function(User $user){
                return view('dashboard.users.action',compact('user'))->render();
            })
            ->editColumn('name', function(User $user){
                return  $user->name ;
            })
            ->editColumn('location_id', function (User $user) {
                return optional($user->location)->title ??"-";
            })
            ->addColumn('is_active', function(User $user){
                return view('dashboard.components.switch-btn',['model'=>$user,'url'=>route('clients.status')])->render();
            })
            ->setRowId('id')
            ->rawColumns(['action','is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function query(UserService $userService): QueryBuilder
    {
        return $userService->queryGet($this->filters,$this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->responsive()
                    ->orderBy(1)
                    ->parameters([
                        'scrollX' => true,
                        'lengthMenu' => [[25, 50,100,"All"], [25, 50,100,"All"]]
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
            ->title('#'),
            Column::make('name')
                ->title(trans('lang.name')),
            Column::make('phone')
                ->title(trans('lang.phone')),
            Column::make('location_id')
                ->title(trans('lang.location')),
            Column::make('points')
                ->title(trans('lang.points'))
                ->searchable(false)
                ->orderable(false),
            Column::make('points_expire_date')
                ->title(trans('lang.points_expire_date'))
                ->searchable(false)
                ->orderable(false),
            Column::make('is_active')
                ->title(trans('lang.status'))
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
        return 'Users_' . date('YmdHis');
    }
}
