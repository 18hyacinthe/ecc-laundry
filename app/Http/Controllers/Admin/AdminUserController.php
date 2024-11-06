<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

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
        // dd($request->all());
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
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users-management.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        // Valider les données envoyées
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:255',
            'status' => ['required'],
            'password' => 'nullable|string|min:8',
        ]);

        // Trouver l'utilisateur et mettre à jour les informations
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = $request->status;

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        toastr()->success('User successfully updated!');
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Trouver l'utilisateur et le supprimer
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'User deleted successfully!']);
    }
}
