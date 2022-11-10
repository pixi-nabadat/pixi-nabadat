<?php

namespace App\DataTables;

use App\Models\Center;
use App\Services\CenterService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CentresDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', function(Center $center){
                return view('dashboard.centers.action',compact('center'))->render();
            })
            ->addcolumn('name', function(Center $center){
               return $center->name;
            })
            ->addcolumn('address', function(Center $center){
                return $center->address;
            })
            ->addcolumn('location', function(Center $center){
                return $center->location->title;
            })
            ->addcolumn('is_active', function(Center $center){
                 return $center->is_active== 1? trans('lang.active') : trans('lang.non_active');
            });
    }

     /**
     * Get query source of dataTable.
     *
     * @param CenterService $locationService
     */
    public function query(CenterService $centerService)
    {
       return $centerService->queryGet($this->filters,$this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom'     => 'Blfrtip',
                'order'   => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'responsive'=>true,
                "bSort" => false
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
            [
                'name'=>'id',
                'data'=>'id',
                'title'=>'#',
            ],
            [
                'name'=>'name',
                'data'=>'name',
                'title'=> 'name',
            ],
            [
                'name'=>'address',
                'data'=>'address',
                'title'=> 'address',
            ],
            [
                'name'=>'phone',
                'data'=>'phone',
                'title'=> 'phone',
            ],
            [
                'name'=>'location',
                'data'=>'location',
                'title'=> 'location',
            ],
            [
                'name'=>'is_active',
                'data'=>'is_active',
                'title'=> 'status',
            ],
            [
                'name'=>'action',
                'data'=>'action',
                'title'=> 'action ',
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
        ];
    }

}
