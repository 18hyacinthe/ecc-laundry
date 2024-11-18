<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.users-management.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Valider les données envoyées
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:2550',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'status' => ['required'],
            'password' => 'required|string|min:8',
        ]);

        // Créer l'utilisateur avec le mot de passe généré
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'password' => Hash::make($request->password), // Hash le mot de passe
        ]);

        // Envoyer un email à l'utilisateur avec ses identifiants
        $this->sendUserCredentials($user->email, $request->password);

        toastr()->success('User successfully created and email sent successfully!');
        return redirect()->route('admin.users.index');
    }

    protected function sendUserCredentials($email, $password)
    {
        $details = [
            'email' => $email,
            'password' => $password,
        ];

        Mail::send('emails.userCredentials', $details, function($message) use ($email) {
            $message->to($email)->subject('Vos informations de connexion');
        });
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
    public function edit(string $hashedId)
    {
        $decodedId = Hashids::decode($hashedId);
        if (empty($decodedId)) {
            abort(404); // Si l'ID est invalide, afficher une erreur
        }

        $id = $decodedId[0];
        $user = User::findOrFail($id);
        return view('admin.users-management.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $hashedId)
    {
        $decodedId = Hashids::decode($hashedId);
        if (empty($decodedId)) {
            abort(404);
        }

        $user = User::findOrFail($decodedId[0]);

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255',
            'role' => ['required'],
            'status' => ['required'],
            'password' => 'nullable|string|min:8',
        ]);

        $user->update($request->only(['name', 'surname', 'email', 'phone', 'role', 'status']));
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        toastr()->success('Utilisateur mis à jour avec succès !');
        return redirect()->route('admin.users.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $hashedId)
    {
        $decodedId = Hashids::decode($hashedId);
        if (empty($decodedId)) {
            return response()->json(['status' => 'error', 'message' => 'ID invalide !']);
        }

        $user = User::findOrFail($decodedId[0]);
        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'Utilisateur supprimé avec succès !']);
    }

}
