<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

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
            'type' => $machine->type, // Assurez-vous que cette propriété est définie dans votre modèle Machine
            'status' => $machine->status, // Assurez-vous que cette propriété est définie dans votre modèle Machine
            'hashedId' => Hashids::encode($machine->id),
            ];
        });

        return view('frontend.machine.index', compact('machinesData', 'washingMachinesCount', 'dryerMachinesCount'));
    }

    public function showMachineDetails($hashedId)
    {
        $id = Hashids::decode($hashedId)[0];
        if (!$id) {
            return redirect()->route('user.machines.index')->with('error', 'Invalid machine ID');
        }
        $machine = Machine::with(['reservations' => function($query) {
            $query->whereDate('start_time', Carbon::today())
                ->orderBy('start_time', 'asc');
        }])->findOrFail($id);

        return view('frontend.machine.machine-details', compact('machine'));
    }


}
