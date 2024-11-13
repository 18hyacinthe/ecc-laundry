<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Ensure the User model is imported
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.profile.index');
    }


    public function updateProfile(Request $request)
    {
        // Valider les champs du formulaire
        $request->validate([
            'name' => 'required|max:100',
            'surname' => 'required|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)],
            'phone' => 'required|max:15',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Vérifier et sauvegarder l'image si elle est présente dans la requête
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // Enregistrer la nouvelle image dans 'storage/app/public/uploads'
            $imagePath = $request->file('image')->store('uploads', 'public');
            $user->image = $imagePath;  // Stocker le chemin relatif
        }

        // Mettre à jour les autres informations de l'utilisateur
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        toastr()->success('Profile Updated Successfully!');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        toastr()->success('Password Updated Successfully!');

        return redirect()->back();
    }

}
