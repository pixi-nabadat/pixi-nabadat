<?php

namespace App\DataTables;

use App\Models\package;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Services\DataTable;

class PackagesDataTable extends DataTable
{
    
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(package $package){
            return view('dashboard.packages.action',compact('package'))->render();
        })
        ->editColumn('name', function(package $package){
            return $package->name ;
        })
        ->editColumn('num_nabadat', function(package $package){
            return $package->num_nabadat ;
        })
        ->editColumn('price', function(package $package){
            return $package->price ;
        })
        ->addColumn('is_active', function(package $package){
            return view('dashboard.components.switch-btn',['model'=>$package,'url'=>route('packages.status')])->render();
        }) 
        ->rawColumns(['action','is_active']);
    }

 
    public function query(package $model): QueryBuilder
    {
        return $model->newQuery();
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('packagesdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name'),
            Column::make('num_nabadat'),
            Column::make('price'),
            Column::make('is_active'),
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
