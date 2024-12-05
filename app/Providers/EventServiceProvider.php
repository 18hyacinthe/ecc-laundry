<?php
// app/Providers/EventServiceProvider.php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\UserActivity;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        Logout::class => [
            'App\Listeners\LogSuccessfulLogout',
        ],
        PasswordReset::class => [
            \App\Listeners\SendPasswordResetNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        // Event::listen(Login::class, function ($event) {
        //     UserActivity::create([
        //         'user_id' => $event->user->id,
        //         'activity' => 'Logged in',
        //     ]);
        // });

        // Event::listen(Logout::class, function ($event) {
        //     UserActivity::create([
        //         'user_id' => $event->user->id,
        //         'activity' => 'Logged out',
        //     ]);
        // });
    }
}