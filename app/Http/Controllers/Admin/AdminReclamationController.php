<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AdminReclamationDataTable;
use App\Models\Reclamation;
use App\Models\Machine;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class AdminReclamationController extends Controller
{
    // Affiche le formulaire de réclamation
    public function index(AdminReclamationDataTable $dataTable)
    {
        return $dataTable->render('admin.reclamations.index');
    }

    public function show($hashedId)
    {
        $id = Hashids::decode($hashedId)[0];
        if (!$id) {
            toastr()->error('Invalid Reclamation ID');
            return redirect()->route('admin.reclamations.index');
        }
        $reclamation = Reclamation::with('machine')->findOrFail($id);
        return view('admin.reclamations.show-reclamation-content', compact('reclamation'));
    }
}
