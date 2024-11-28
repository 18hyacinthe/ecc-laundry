<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Redirige en fonction du rôle de l'utilisateur connecté
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif (Auth::user()->role === 'user') {
                return redirect('/user/dashboard');
            }
        }

        // Si l'utilisateur n'est pas connecté, affiche la page de connexion
        return view('frontend.auth.master');
    }
}
