<?php
// app/Providers/EventServiceProvider.php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\UserActivity;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            'App\Listeners\LogSuccessfulLogin',
        ],
    ];

    public function boot()
    {
        parent::boot();

        Event::listen(Login::class, function ($event) {
            UserActivity::create([
                'user_id' => $event->user->id,
                'activity' => 'Logged in',
            ]);
        });
    }
}