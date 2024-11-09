<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MachineDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;

class AdminMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MachineDataTable $dataTable)
    {
        return $dataTable->render('admin.machines.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.machines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:washing-machine,dryer',
            'status' => 'required|string|in:reserved,in-use,available,under maintenance,out of order',
            'color' => 'required|string|max:7', // Add validation for color
        ]);

        $machine = new Machine();
        $machine->name = $request->input('name');
        $machine->type = $request->input('type');
        $machine->status = $request->input('status');
        $machine->color = $request->input('color'); // Save color
        $machine->save();

        toastr()->success('Machine créée avec succès!');
        return redirect()->route('admin.machines.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $machine = Machine::findOrFail($id);
        return view('admin.machines.edit', compact('machine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:washing-machine,dryer',
            'status' => 'required|string|in:reserved,in-use,available,under maintenance,out of order',
            'color' => 'required|string|max:7', // Add validation for color
        ]);

        $machine = Machine::findOrFail($id);
        $machine->name = $request->input('name');
        $machine->type = $request->input('type');
        $machine->status = $request->input('status');
        $machine->color = $request->input('color'); // Save color
        $machine->save();

        toastr()->success('Machine mise à jour avec succès!');
        return redirect()->route('admin.machines.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $machine = Machine::findOrFail($id);
        $machine->delete();
        return response()->json(['status' => 'success', 'message' => 'Machine supprimée avec succès!']);
    }
}
