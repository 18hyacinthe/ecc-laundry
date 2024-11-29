<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;
use App\Models\UserActivity;

class LogSuccessfulLogout
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if ($event->user) {
            UserActivity::create([
                'user_id' => $event->user->id,
                'activity' => 'Logged out',
            ]);
        } else {
            Log::warning('Logout event triggered without a user.');
        }
    }
}