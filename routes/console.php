<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Reservation;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('app:my-awesome-command', function () {
    // Supprime les réservations expirées
    Reservation::where('end_time', '<', now())->delete();

    $this->info('Toutes les sessions de réservation ont été réinitialisées.');
})->purpose('Command description')->hourly();