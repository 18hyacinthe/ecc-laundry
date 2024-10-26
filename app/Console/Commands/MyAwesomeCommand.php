<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;

class MyAwesomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:my-awesome-command';
    protected $signature = 'app:reset-sessions';


    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    protected $description = 'Réinitialiser toutes les sessions de réservation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Supprime les réservations expirées
        Reservation::where('end_time', '<', now())->delete();

        $this->info('Toutes les sessions de réservation ont été réinitialisées.');
    }
}
