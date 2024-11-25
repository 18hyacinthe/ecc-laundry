<?php

namespace App\DataTables;

use App\Models\AdminHistoriqueReservation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Reservation;
use Vinkla\Hashids\Facades\Hashids;

class AdminHistoriqueReservationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function ($query) {
            $hashedId = Hashids::encode($query->id);
            $editBtn = "<a href='" . route('admin.reservation.edit', ['hashedId' => $hashedId]) . "' class='btn btn-sm btn-primary ml-2' title='" . __('Edit') . "'><i class='far fa-edit'></i></a>";
            $viewBtn = "<button class='btn btn-sm btn-info ml-2' title='" . __('View') . "' onclick='showReservationDetails(\"" . $hashedId . "\")'><i class='fa fa-eye'></i></button>";
            $deleteBtn = "<button class='btn btn-sm btn-danger ml-2' title='" . __('Delete') . "' onclick='deleteReservation(\"" . $hashedId . "\")'><i class='far fa-trash-alt'></i></button>";
            $deleteForm = "<form id='delete-form-" . $hashedId . "' action='" . route('admin.reservations.destroy', ['hashedId' => $hashedId]) . "' method='POST' style='display: none;'>
                    " . csrf_field() . "
                    " . method_field('DELETE') . "
                    </form>";
            return $editBtn . $viewBtn . $deleteBtn . $deleteForm;
            })
            ->editColumn('user_id', function($query) {
                return $query->user->name;
            })
            ->editColumn('machine_id', function($query) {
                return $query->machine->name;
            })
            ->editColumn('created_at', function($query) {
                return $query->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('start_time', function($query) {
                return $query->start_time->format('d/m/Y H:i:s');
            })
            ->editColumn('end_time', function($query) {
                return $query->end_time->format('d/m/Y H:i:s');
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Reservation $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('adminhistoriquereservation-table')
                    ->columns($this->getColumns())
                    // ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->responsive(true)
                    ->rowReorder([
                        'selector' => 'td:nth-child(2)'
                    ])
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('No')->addClass('text-center'),
            Column::make('user_id')->title('Utilisateur')->addClass('text-center'),
            Column::make('machine_id')->title('Machine')->addClass('text-center'),
            Column::make('start_time')->title('Date de début')->addClass('text-center'),
            Column::make('end_time')->title('Date de fin')->addClass('text-center'),
            Column::make('created_at')->title('Créé à')->addClass('text-center'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(200)
                  ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AdminHistoriqueReservation_' . date('YmdHis');
    }
}
