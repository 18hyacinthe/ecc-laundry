<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\VerifyEmailUser;
use Illuminate\Support\Facades\Event;
use App\Events\Registered;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
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
        // if(config('app.env') === 'local') {
        //     URL::forceScheme('https');
        // }

        // Event::listen(
        //     Registered::class,
        //     SendWelcomeEmail::class
        // );

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);
        });

        // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        //     return new VerifyEmailUser($notifiable->email, $url);
        // });
    }

}
