<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // URL visitée
            $table->string('ip_address')->nullable(); // Adresse IP
            $table->unsignedBigInteger('user_id')->nullable(); // Utilisateur connecté
            $table->string('user_agent')->nullable(); // Informations sur le navigateur
            $table->timestamp('visited_at')->default(now()); // Date et heure de la visite
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
