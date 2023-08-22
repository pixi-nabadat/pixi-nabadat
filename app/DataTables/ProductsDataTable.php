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
            ->addColumn('action', function (Product $product) {
                return view('dashboard.products.action', compact('product'))->render();
            })
            ->editColumn('name', function (Product $product) {
                return  $product->name;
            })
            ->editColumn('description', function (Product $product) {
                return  $product->description;
            })
            ->editColumn('stock', function (Product $product) {
                return  $product->stock;
            })
            ->editColumn('category_id', function (Product $product) {
                return  $product->category->name;
            })
            ->editColumn('type', function (Product $product) {
                return  $product->type;
            })
            ->addColumn('featured', function (Product $product) {
                return view('dashboard.components.switch-featured-btn', ['model' => $product, 'url' => route('products.featured')])->render();
            })
            ->addColumn('is_active', function (Product $product) {
                return view('dashboard.components.switch-btn', ['model' => $product, 'url' => route('products.status')])->render();
            })
            ->rawColumns(['action', 'featured', 'is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param ProductService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProductService $model): QueryBuilder
    {
        return $model->queryGet($this->filters, $this->withRelations);
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
            ->parameters([
                'scrollX'=>true
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
            Column::make('name')
                ->title(trans('lang.name')),
            Column::make('category_id')
                ->title(trans('lang.category_id'))
                ->searchable(false)
                ->orderable(true),
            Column::make('type')
                ->title(trans('lang.type'))
                ->searchable(false)
                ->orderable(false),
            Column::make('description')
                ->title(trans('lang.description'))
                ->searchable(false)
                ->orderable(false),
            Column::make('unit_price')
                ->title(trans('lang.unit_price'))
                ->searchable(false)
                ->orderable(false),
            Column::make('purchase_price')
                ->title(trans('lang.purchase_price'))
                ->searchable(false)
                ->orderable(false),
            Column::make('stock')
                ->title(trans('lang.stock'))
                ->searchable(false)
                ->orderable(false),
            Column::make('discount')
                ->title(trans('lang.discount'))
                ->searchable(false)
                ->orderable(false),
            Column::make('featured')
                ->title(trans('lang.featured'))
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
        return 'Products_' . date('YmdHis');
    }

}
