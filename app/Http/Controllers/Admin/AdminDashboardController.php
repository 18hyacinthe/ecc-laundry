<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Support\Facades\DB;
use App\DataTables\AdminHistoriqueReservationDataTable;

class AdminDashboardController extends Controller
{
    public function index(AdminHistoriqueReservationDataTable $dataTable)
    {
        $machines = Machine::all();
        $machineCounts = Machine::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get();
            return $dataTable->render('admin.dashboard.common.dashboard', compact('machines', 'machineCounts'));
    }
}
