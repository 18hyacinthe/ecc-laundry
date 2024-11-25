<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AdminReclamationDataTable;
use App\Models\Reclamation;
use App\Models\Machine;
use Illuminate\Support\Facades\Auth;

class AdminReclamationController extends Controller
{
    // Affiche le formulaire de réclamation
    public function index(AdminReclamationDataTable $dataTable)
    {
        return $dataTable->render('admin.reclamations.index');
    }

    // Affiche le formulaire de réclamation avec les machines disponibles
    // public function create()
    // {
    //     $machines = Machine::all();
    //     return view('admin.reclamations.create', compact('machines'));
    // }

    public function show($id)
    {
        $reclamation = Reclamation::with('machine')->findOrFail($id);
        return view('admin.reclamations.show-reclamation-content', compact('reclamation'));
    }
    


    // Enregistre la réclamation dans la base de données
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'machine_id' => 'required|exists:machines,id',
    //         'title' => 'required|string|max:255',
    //         'machine_type' => 'required|string',
    //         'issue_type' => 'required|string',
    //         'description' => 'required|string',
    //         'status' => 'required|string',
    //     ]);

    //     Reclamation::create([
    //         'user_id' => Auth::id(),
    //         'machine_id' => $request->machine_id,
    //         'title' => $request->title,
    //         'machine_type' => $request->machine_type,
    //         'issue_type' => $request->issue_type,
    //         'description' => $request->description,
    //         'status' => $request->status,
    //     ]);

    //     toastr()->success('Votre réclamation a été soumise avec succès.');

    //     return redirect()->route('admin.reclamations.index');
    // }
}
