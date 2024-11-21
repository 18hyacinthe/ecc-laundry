<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserReclamationDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Auth;
use App\Models\Machine;
use App\Models\User;
use App\Notifications\ReclamationCreated;
use Illuminate\Support\Facades\Notification;
use Vinkla\Hashids\Facades\Hashids;

class UserReclamationController extends Controller
{
    // Affiche le formulaire de réclamation
    public function index(UserReclamationDataTable $dataTable)
    {
        return $dataTable->render('frontend.reclamations.index');
    }

    // Affiche le formulaire de réclamation avec les machines disponibles
    public function create()
    {
        $machines = Machine::all();
        return view('frontend.reclamations.create', compact('machines'));
    }

    public function show($hashedId)
    {
        $id = Hashids::decode($hashedId)[0];
        if (!$id) {
            toastr()->error('Invalid Reclamation ID');
            return redirect()->route('user.reclamations.index');
        }
        $reclamation = Reclamation::with('machine')->findOrFail($id);
        return view('frontend.reclamations.show-reclamation-content', compact('reclamation'));
    }
    


    // Enregistre la réclamation dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'title' => 'required|string|max:255',
            'machine_type' => 'required|string',
            'issue_type' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
        ]);

        $reclamation = Reclamation::create([
            'user_id' => Auth::id(),
            'machine_id' => $request->machine_id,
            'title' => $request->title,
            'machine_type' => $request->machine_type,
            'issue_type' => $request->issue_type,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Récupérer tous les utilisateurs avec le rôle admin
        $admins = User::where('role', 'admin')->get();

        // Envoyer la notification à tous les admins et à l'utilisateur
        Notification::send($admins, new ReclamationCreated($reclamation));
        Auth::user()->notify(new ReclamationCreated($reclamation));

        toastr()->success('Votre réclamation a été soumise avec succès.');

        return redirect()->route('user.reclamations.index');
    }
}
