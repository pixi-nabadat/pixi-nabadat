<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\Location;
use App\Models\User;
use App\Services\LocationService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
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
        ->addColumn('action', function(Product $product){
            return view('dashboard.products.action',compact('product'))->render();
        })
        ->editColumn('name', function(Product $product){
            return  $product->name ;
        })
        ->editColumn('description', function(Product $product){
            return  $product-> description;
        })
        ->editColumn('stock', function(Product $product){
            return  $product-> stock;
        })
        ->editColumn('discount_type', function(Product $product){
            return  $product-> discount_type==0?trans('lang.flat'):trans('lang.percent');
        })
        ->editColumn('added_by', function(Product $product){
            return  $product->user->name ;
        })
        ->addColumn('featured', function(Product $product){
            return view('dashboard.components.switch-featured-btn',['model'=>$product,'url'=>route('products.featured')])->render();
        })
        ->addColumn('is_active', function(Product $product){
            return view('dashboard.components.switch-btn',['model'=>$product,'url'=>route('products.status')])->render();
        })
        ->rawColumns(['action','featured','is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param ProductService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProductService $model): QueryBuilder
    {
        return $model->queryGet($this->filters,$this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productsdatatable-table')
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
            Column::make('name'),
            Column::make('added_by'),
            Column::make('description'),
            Column::make('unit_price'),
            Column::make('purchase_price'),
            Column::make('stock'),
            Column::make('discount'),
            Column::make('discount_type'),
            Column::make('featured'),
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
        return 'Products_' . date('YmdHis');
    }

}
