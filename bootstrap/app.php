<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrement des alias de middleware
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'checkWeeklyLimit' => \App\Http\Middleware\CheckWeeklyReservationLimit::class,
            'checkSlotAvailability' => \App\Http\Middleware\CheckSlotAvailability::class,
            'checkSessionDuration' => \App\Http\Middleware\CheckSessionDuration::class,
            'check.email.domain.register' => \App\Http\Middleware\CheckEmailDomainRegister::class,
            'check.email.domain.login' => \App\Http\Middleware\CheckEmailDomainLogin::class,
            'check.user.status' => \App\Http\Middleware\UserStatusChecker::class,
            // 'TrackPageViews' => \App\Http\Middleware\TrackPageViews::class
        ]);

        // Groupes de middlewares
        $middleware->group('web', [
            // Autres middlewares Web
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\LanguageMiddleware::class,
            \App\Http\Middleware\TrackPageViews::class,
        ]);

        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function () {
        // Gestionnaire d'exceptions spécifique, si nécessaire
    })
    ->withCommands([
        \App\Console\Commands\MyAwesomeCommand::class,
        \App\Console\Commands\SendReservationNotification::class,
    ])
    ->withSchedule(function (Schedule $schedule) {
        // $schedule->command('reservation:notify')->everyMinute()->withoutOverlapping();
        // $schedule->command('app:reset-sessions')->weekly()->description('Réinitialiser toutes les sessions de réservation');
    })
    ->create();