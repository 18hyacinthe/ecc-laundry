<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table users
            $table->foreignId('machine_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table machines
            $table->timestamp('start_time')->nullable(); // Heure de début de la réservation
            $table->timestamp('end_time')->nullable();   // Heure de fin de la réservation
            $table->integer('weekly_session_limit_remaining')->default(0); // Nombre de sessions hebdomadaires restantes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
