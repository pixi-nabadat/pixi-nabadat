<?php

namespace App\DataTables;

use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReservationDataTable extends DataTable
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
            ->addColumn('customer_id', function (Reservation $reservation) {
                return $reservation->user->name;
            })
            ->addColumn('center_id', function (Reservation $reservation) {
                return $reservation->center->name;
            })
            ->addColumn('status', function (Reservation $reservation) {
                return $reservation->history->last()->status;
            })
            ->addColumn('action', function (Reservation $reservation) {
                return view('dashboard.reservations.action', compact('reservation'))->render();
            })->rawColumns(['action', 'is_active']);
    }

    /**
     * @param ReservationService $model
     * @return QueryBuilder
     */
    public function query(ReservationService $model): QueryBuilder
    {
        return $model->queryGet($this->filters , $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('reservation-datatable-table')
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
            Column::make('id')
                ->title('Id')
                ->searchable(true)
                ->orderable(true),
            Column::make('customer_id')
                ->title(trans('lang.user'))
                ->searchable(true)
                ->orderable(true),
            Column::make('center_id')
                ->title(trans('lang.center'))
                ->searchable(true)
                ->orderable(true),
            Column::make('check_date')
                ->title(trans('lang.check_date'))
                ->searchable(true)
                ->orderable(true),
            Column::make('from')
                ->title(trans('lang.from'))
                ->searchable(false)
                ->orderable(false),
            Column::make('to')
                ->title(trans('lang.to'))
                ->searchable(true)
                ->orderable(true),
            Column::make('payment_type')
                ->title(trans('lang.payment_type'))
                ->searchable(false)
                ->orderable(false),
            Column::make('payment_status')
                ->title(trans('lang.payment_status'))
                ->searchable(false)
                ->orderable(false),
            Column::make('qr_code')
                ->title(trans('lang.qr_code'))
                ->searchable(true)
                ->orderable(true),
            Column::make('status')
                ->title(trans('lang.status'))
                ->searchable(false)
                ->orderable(false),
            // Column::computed('action')
            //     ->width(60)
            //     ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'reservations' . date('YmdHis');
    }

}
