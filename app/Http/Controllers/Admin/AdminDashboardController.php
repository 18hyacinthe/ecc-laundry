<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $machines = Machine::all();
        $machineCounts = Machine::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get();
        return view('admin.dashboard.common.dashboard', compact('machines', 'machineCounts'));
    }
}
