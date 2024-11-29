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
        $machineColors = Machine::pluck('color', 'name')->toArray(); // Récupère les couleurs associées aux noms des machines
        // Ajouter les statistiques des pages
        $pageViews = DB::table('page_views')
        ->select('url', DB::raw('count(*) as views'), DB::raw('max(visited_at) as last_visited'))
        ->groupBy('url')
        ->orderByDesc('views')
        ->take(5)
        ->get();

        // Données pour les graphiques
        // $reservationsByDay = Reservation::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
        //     ->groupBy('date')
        //     ->orderBy('date')
        //     ->get();
        $reservationsByDay = Reservation::select('machines.type', DB::raw('DATE(reservations.created_at) as date'), DB::raw('count(*) as count'))
        ->join('machines', 'reservations.machine_id', '=', 'machines.id')
        ->groupBy('machines.type', 'date')
        ->orderBy('date')
        ->get()
        ->groupBy('type');

        $reservationsByMachine = Reservation::select(
            'machines.name as machine_name', 
            DB::raw('DATE(reservations.created_at) as date'), 
            DB::raw('count(*) as count')
        )
        ->join('machines', 'reservations.machine_id', '=', 'machines.id')
        ->groupBy('machines.name', 'date')
        ->orderBy('date')
        ->get()
        ->groupBy('machine_name');        

        $userActivities = UserActivity::orderBy('created_at', 'desc')->take(5)->get();
        $loginsByDay = UserActivity::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
        ->where('activity', 'Logged in')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $loginCount = UserActivity::where('activity', 'Logged in')->count();

        // dd($userActivities);
        // dd($loginCount); 
        // dd($reservationsByType);   

        return $dataTable->render('admin.dashboard.common.dashboard', compact('machines', 'machineCounts', 'pageViews', 'reservationsByDay', 'userActivities', 'loginCount', 'loginsByDay', 'reservationsByMachine', 'machineColors'));
    }
}
