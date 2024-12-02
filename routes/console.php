<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Reservation;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\SendReservationNotification;

Artisan::command('app:reset-sessions', function () {
    // Supprime les réservations expirées
    Reservation::where('end_time', '<', now())->delete();

    $this->info('Toutes les sessions de réservation ont été réinitialisées.');
})->purpose('Réinitialiser toutes les sessions de réservation');



// Schedule::command('app:reset-sessions')
//     ->weekly()
//     ->description('Réinitialiser toutes les sessions de réservation');

// Schedule::command('reservation:notify')
//     ->everyMinute()
//     ->withoutOverlapping();
