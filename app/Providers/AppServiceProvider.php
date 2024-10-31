<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\Registered;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Support\Facades\URL;
// use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(config('app.env') === 'local') {
            URL::forceScheme('https');
        }

        Event::listen(
            Registered::class,
            SendWelcomeEmail::class
        );
    }

}
