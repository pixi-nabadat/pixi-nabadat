<?php

namespace App\DataTables;

use App\Models\PackageCategory;
use App\Models\Location;
use App\Services\PackageCategoryService;
use App\Services\LocationService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PackageCategoriesDataTable extends DataTable
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
        ->addColumn('action', function(PackageCategory $packageCategory){
            return view('dashboard.package-categories.action',compact('packageCategory'))->render();
        })
        ->editColumn('name', function(PackageCategory $packageCategory){
            return $packageCategory->name ;
        })
        ->addcolumn('is_active', function(PackageCategory $packageCategory){
            return  view('dashboard.components.switch-btn',['model'=>$packageCategory,'url'=>route('package-categories.changeStatus')]);
        })->rawColumns(['action','is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PackageCategoryService $packageCategoryService
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PackageCategoryService $packageCategoryService): QueryBuilder
    {
        return $packageCategoryService->queryGet($this->filters, $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('packageCategoriesdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
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
            
            Column::make('name')
            ->title(trans('lang.name')),

            Column::make('created_at')
                ->title(trans('lang.created_at'))
                ->searchable(false)
                ->orderable(false),

            Column::computed('is_active')
                ->title(trans('lang.status'))
                ->searchable(false)
                ->orderable(false),

            Column::computed('action')
                  ->title(trans('lang.action'))
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
        return 'categories_' . date('YmdHis');
    }

}
