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
        ->editColumn('name', function (User $user) {
            return $user->name;
        })
        ->editColumn('description', function (User $user) {
            return $user->description;
        })
        ->editColumn('center_id', function (User $user) {
            return $user->center_id == null ? null:$user->center->name;
        })
        ->editColumn('location_id', function (User $user) {
            return $user->location->title;
        })
        ->addColumn('action', function (User $user) {
            return view('dashboard.users.action', compact('user'))->render();
        })
        ->addColumn('is_active', function (User $user) {
            return view('dashboard.components.switch-btn', ['model' => $user, 'url' => route('users.status')])->render();
        })
        ->rawColumns(['action', 'is_active']);
}

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function query(UserService $userService): QueryBuilder
    {
        return $userService->queryGet($this->filters)->with('location');
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
                ->title('Id')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Id')
                ->exportable(true)
                ->printable(true),
            Column::make('name')
                ->title('Name')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Name')
                ->exportable(true)
                ->printable(true),
            Column::make('email')
                ->title('Email')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Email')
                ->exportable(true)
                ->printable(true),
            Column::make('user_name')
                ->title('User Name')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('User Name')
                ->exportable(true)
                ->printable(true),
            Column::make('phone')
                ->title('Phone')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Phone')
                ->exportable(true)
                ->printable(true),
            Column::make('type')
                ->title('Type')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Type')
                ->exportable(true)
                ->printable(true),
            Column::make('center_id')
                ->title('Center')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Center')
                ->exportable(true)
                ->printable(true),
            Column::make('is_active')
                ->title('Is Active')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Is Active')
                ->exportable(true)
                ->printable(true),
            Column::make('location_id')
                ->title('Location')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Location')
                ->exportable(true)
                ->printable(true),
            Column::make('date_of_birth')
                ->title('Date OF Birth')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Date OF Birth')
                ->exportable(true)
                ->printable(true),
            Column::make('description')
                ->title('Description')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Description')
                ->exportable(true)
                ->printable(true),
            Column::make('points')
                ->title('Points')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Points')
                ->exportable(true)
                ->printable(true),
            Column::make('points_expire_date')
                ->title('Points Expire Date')
                ->searchable(true)
                ->orderable(true)
                // ->render('function(){}')
                ->footer('Points Expire Date')
                ->exportable(true)
                ->printable(true),
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
        return 'Users_' . date('YmdHis');
    }
}
