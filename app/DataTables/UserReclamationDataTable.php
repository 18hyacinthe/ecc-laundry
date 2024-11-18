<?php

namespace App\DataTables;

use App\Models\UserReclamation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class UserReclamationDataTable extends DataTable
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
                $viewBtn = "<button class='btn btn-sm btn-primary' onclick='showReclamationDetails(\"" . $hashedId . "\")' title='" . __('View') . "'><i class='fa fa-eye'></i></button>";
                return $viewBtn;
            })
            ->editColumn('created_at', function($query) {
                return $query->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('status', function ($query) {
                $statusLabels = [
                    'Important' => '<i class="badge badge-success">' . __('Important') . '</i>',
                    'Urgent' => '<i class="badge badge-warning">' . __('Urgent') . '</i>',
                    'Très urgent' => '<i class="badge badge-danger">' . __('Très urgent') . '</i>',
                ];
                return $statusLabels[$query->status] ?? $query->status;
            })
            ->editColumn('machine_id', function ($reclamation) {
                return $reclamation->machine ? $reclamation->machine->name : 'N/A';
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
  
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Reclamation $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model->newQuery()->where('user_id', Auth::id())->with('machine');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('userreclamation-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->responsive(true)
                    ->rowReorder([
                        'selector' => 'td:nth-child(3)'
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
            Column::make('title')->title('Titre')->addClass('text-center'),
            Column::make('machine_id')->title('Machine')->addClass('text-center'),
            Column::make('machine_type')->addClass('text-center'),
            Column::make('issue_type')->addClass('text-center'),
            Column::make('description')->addClass('text-center'),
            Column::make('status')->addClass('text-center'),
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
        return 'UserReclamation_' . date('YmdHis');
    }
}
