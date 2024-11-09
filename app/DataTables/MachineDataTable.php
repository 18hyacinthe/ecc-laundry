<?php

namespace App\DataTables;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MachineDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
             ->addColumn('action', function($query) {
                $editBtn = "<a href='" . route('admin.machines.edit', $query->id) . "' class='btn btn-primary'><i class='far fa-edit'></i></a>";
                $deleteBtn = "<button class='btn btn-danger ml-2' onclick='deleteMachine(" . $query->id . ")'><i class='far fa-trash-alt'></i></button>";
                $deleteBtn .= "<form id='delete-form-" . $query->id . "' action='" . route('admin.machines.destroy', $query->id) . "' method='POST' style='display: none;'>
                                " . csrf_field() . "
                                " . method_field('DELETE') . "
                              </form>";
                return $editBtn . $deleteBtn;
            })
            ->editColumn('status', function($query) {
                switch ($query->status) {
                    case 'reserved':
                        return '<span class="badge badge-success">Reserved</span>';
                    case 'in-use':
                        return '<span class="badge badge-primary">In Use</span>';
                    case 'available':
                        return '<span class="badge badge-success">Available</span>';
                    case 'under maintenance':
                        return '<span class="badge badge-info">Under Maintenance</span>';
                    case 'out of order':
                        return '<span class="badge badge-danger">Out of Order</span>';
                    default:
                        return '<span class="badge badge-secondary">Unknown</span>';
                }
            })
            ->editColumn('color', function($query) {
                return "<div style='width: 20px; height: 20px; background-color: " . $query->color . "; border-radius: 50%; border: 2px solid #000; margin: 0 auto;'></div>";
            })
            ->rawColumns(['action', 'color', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Machine $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('machine-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')
                    ->layout([
                        'topStart' => [
                            'buttons' => ['copy', 'csv', 'excel', 'pdf', 'print']
                        ]
                    ])
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
            Column::make('id')->addClass('text-center'),
            Column::make('name')->addClass('text-center'),
            Column::make('type')->addClass('text-center'),
            Column::make('status')->addClass('text-center'),
            Column::computed('action')->addClass('text-center'),
            Column::make('color')->addClass('text-center')
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
        return 'Machine_' . date('YmdHis');
    }
}
