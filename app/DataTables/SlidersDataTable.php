<?php

namespace App\DataTables;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Services\SliderService;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Services\DataTable;

class SlidersDataTable extends DataTable
{

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(Slider $slider){
            return view('dashboard.sliders.action',compact('slider'))->render();
        })
        ->editColumn('package_id', function(Slider $slider){
            return $slider->package->name ;
        })
        
        ->addColumn('is_active', function(Slider $slider){
            return view('dashboard.components.switch-btn',['model'=>$slider,'url'=>route('sliders.status')])->render();
        })
        ->rawColumns(['action','is_active']);
    }


    public function query(SliderService $model): QueryBuilder
    {
        return $model->queryGet($this->filters,$this->withRelations);
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('slidersdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1);
    }

    protected function getColumns(): array
    {
        return [
            Column::make('order'),
            Column::make('package_id')
            ->title(trans('package_name')),
            Column::make('start_date'),
            Column::make('end_date'),
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
        return 'Sliders_' . date('YmdHis');
    }

}
