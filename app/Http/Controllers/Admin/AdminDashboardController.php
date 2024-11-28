<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Support\Facades\DB;
use App\DataTables\AdminHistoriqueReservationDataTable;
use App\Models\Reservation;
use App\Models\UserActivity;

class AdminDashboardController extends Controller
{
    public function index(AdminHistoriqueReservationDataTable $dataTable)
    {
        $machines = Machine::all();
        $machineCounts = Machine::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get();

        // Ajouter les statistiques des pages
        $pageViews = DB::table('page_views')
        ->select('url', DB::raw('count(*) as views'), DB::raw('max(visited_at) as last_visited'))
        ->groupBy('url')
        ->orderByDesc('views')
        ->take(10)
        ->get();

        // Données pour les graphiques
        $reservationsByDay = Reservation::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $userActivities = UserActivity::orderBy('created_at', 'desc')->take(10)->get();
        $loginCount = UserActivity::where('activity', 'Logged in')->count();

        return $dataTable->render('admin.dashboard.common.dashboard', compact('machines', 'machineCounts', 'pageViews', 'reservationsByDay', 'userActivities', 'loginCount'));
    }
}
