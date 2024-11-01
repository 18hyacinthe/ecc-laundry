<?php
namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class SendWelcomeEmail
{
    // public function handle(Registered $event)
    // {
    //     $user = $event->user;
    //     Mail::to($user->email)->send(new WelcomeEmail($user));
    // }
}