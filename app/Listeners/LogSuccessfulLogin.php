<?php
 
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\UserActivity;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        UserActivity::create([
            'user_id' => $event->user->id,
            'activity' => 'Logged in',
        ]);
    }
}