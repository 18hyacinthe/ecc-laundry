<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;


class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // if ($request->user()->hasVerifiedEmail()) {
        //     return redirect()->intended(route('user.dashboard', absolute: false).'?verified=1');
        // }

        // if ($request->user()->markEmailAsVerified()) {
        //     event(new Verified($request->user()));
        // }

        // toastr()->success( __('Email vérifié avec succès!'));
        // return redirect()->intended(route('login', absolute: false).'?verified=1');

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('user.dashboard', absolute: false).'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            toastr()->success(__('Email vérifié avec succès!'));
            
            // Envoi de l'email de bienvenue après la vérification de l'email
            Mail::to($user->email)->send(new WelcomeEmail($user));

            return redirect()->intended(route('user.dashboard', absolute: false).'?verified=1');
        }

        toastr()->error(__('La vérification de l\'email a échoué.'));
        return redirect()->route('user.dashboard');
    }
}
