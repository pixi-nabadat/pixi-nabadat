<?php

namespace App\DataTables;

use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GovernoratesDataTable extends DataTable
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
            ->addColumn('action', function(Location $location){
                return view('dashboard.locations.governorate.action',compact('location'))->render();
            })
            ->addcolumn('title', function(Location $location){
                // $title = json_decode($location->title ?? []);
                return $location->title ;
            })
            // ->addcolumn('title_en', function(Location $location){
            //     $title = json_decode($location->title ?? []);
            //     return $title->en ??'';
            // })
            ;
    }

    /**
    * Get query source of dataTable.
    *
    * @param LocationService $locationService
    */
    public function query(LocationService $locationService)
    {
       return $locationService->queryGet($this->filters);
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
                // 'buttons'      => ['export', 'print', 'create'],
                'buttons'      => [],
                // 'language' => ['url' => asset('dashboard/assets/js/ar-datatable.json')],

                'responsive'=>true,
                "bSort" => false
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'name'=>'id',
                'data'=>'id',
                'title'=>'#',
            ],
            [
                'name'=>'slug',
                'data'=>'slug',
                'title'=> 'slug',
            ],
            [
                'name'=>'title',
                'data'=>'title',
                'title'=> 'title',
            ],
            // [
            //     'name'=>'title_en',
            //     'data'=>'title_en',
            //     'title_en'=> 'title_en',
            // ],
            [
                'name'=>'action',
                'data'=>'action',
                'title'=> 'edit ',
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */

}

