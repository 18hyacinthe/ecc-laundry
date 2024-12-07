<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use Carbon\Carbon;

class MachineOverviewController extends Controller
{
    public function index(Request $request)
    {
        $washingMachinesCount = Machine::where('type', 'washing-machine')->count();
        $dryerMachinesCount = Machine::where('type', 'dryer')->count();
        // Obtenir le décalage horaire de l'utilisateur depuis la requête
        $machines = Machine::all();

        $machinesData = $machines->map(function($machine) {
            return [
            'id' => $machine->id,
            'name' => $machine->name,
            'type' => $machine->type, 
            'status' => $machine->status,
            ];
        });

        return view('frontend.machine.index', compact('machinesData', 'washingMachinesCount', 'dryerMachinesCount'));
    }

    public function showMachineDetails($id)
    {
        $machine = Machine::with(['reservations' => function($query) {
            $query->whereDate('start_time', Carbon::today())
                ->orderBy('start_time', 'asc');
        }])->findOrFail($id);

        $machineName = $machine->name;
        
        return response()->json([
            'machineName' => $machineName,
            'view' => view('frontend.machine.machine-details', compact('machine'))->render()
        ]);
    }


}
