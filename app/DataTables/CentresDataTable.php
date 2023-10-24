<?php

namespace App\DataTables;

use App\Enum\CenterStatusEnum;
use App\Models\Center;
use App\Services\CenterService;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CentresDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn(
                'action', function (Center $center) {
                return view('dashboard.centers.action', compact('center'))->render();
            })
            ->addColumn('name', function (Center $center) {
                return $center->user->name;
            })
            ->editColumn('address', function (Center $center) {
                return $center->address;
            })
            ->editColumn('status', function (Center $center) {
                return $center->center_status;
            })
            ->editColumn('phones', function (Center $center) {
                return view('dashboard.centers._phones_column',compact('center'))->render();
            })
            ->addColumn('featured', function(Center $center){
                return view('dashboard.components.switch-featured-btn',['model'=>$center,'url'=>route('centers.featured')])->render();
            })
            ->editColumn('is_active', function (Center $center) {
                return  view('dashboard.components.switch-btn',['model'=>$center->user,'url'=>route('centers.changeStatus')]);
            })
            ->editColumn('is_support_auto_service', function (Center $center) {
                return  view('dashboard.components.switch-support-auto-service-btn',['model'=>$center,'url'=>route('centers.support-auto-service.changeStatus')]);
            })
            ->editColumn('created_at', function (Center $center) {
                return Carbon::parse($center->created_at)->setTimezone('Africa/Cairo')->format('Y-m-d');
            })
            ->rawColumns(['action','phones','featured','is_active','is_support_auto_service']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param CenterService $locationService
     */
    public function query(CenterService $centerService)
    {
        return $centerService->queryGet($this->filters, $this->withRelations);
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
                'dom' => 'Blfrtip',
                'order' => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "responsive" => true,
                "scrollX" => '100%',
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
            Column::make('address')
                ->title(trans('lang.address')),
            Column::make('phones')
                ->searchable(false)
                ->orderable(false)
                ->title(trans('lang.phones')),
            Column::make('pulse_price')
                ->title(trans('lang.pulse_price'))
                ->searchable(false)
                ->orderable(false),
            Column::make('pulse_discount')
                ->title(trans('lang.pulse_discount'))
                ->searchable(false)
                ->orderable(false),
            Column::make('app_discount')
                ->title(trans('lang.discount')."%")
                ->searchable(false)
                ->orderable(false),
            Column::make('featured')
                ->searchable(false)
                ->title(trans('lang.featured'))
                ->orderable(false),
            Column::make('is_support_auto_service')
                ->title(trans('lang.auto_service'))
                ->searchable(false)
                ->orderable(false),
            Column::make('is_active')
                ->title(trans('lang.is_active'))
                ->searchable(false)
                ->orderable(false),
            Column::make('status')
                ->title(trans('lang.status'))
                ->searchable(false)
                ->orderable(false),
            Column::make('devices_count')
                ->title(trans('lang.devices'))
                ->searchable(false)
                ->orderable(false),
            Column::make('created_at')
                ->title(trans('lang.created_at'))
                ->searchable(false)
                ->orderable(false),
            Column::computed('action')
                ->title(trans('lang.action'))
                ->width(60),
        ];
    }

}
