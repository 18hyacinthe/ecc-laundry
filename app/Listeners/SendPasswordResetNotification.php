<?php
// app/Listeners/SendPasswordResetNotification.php
namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        Mail::to($event->user->email)->send(new \App\Mail\PasswordResetSuccess($event->user));
    }
}