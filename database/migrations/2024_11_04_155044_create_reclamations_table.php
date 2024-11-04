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
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('machine_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table machines
            $table->string('title'); // Titre de la réclamation
            $table->string('machine_type'); // Exemple : 'machine à laver' ou 'sèche-linge'
            $table->enum('issue_type', ['Défaut technique', 'Problème de performance', 'Problème de sécurité']); // Exemple : 'Défaut technique', 'Problème de performance', 'Problème de sécurité'
            $table->text('description'); // Détails supplémentaires
            $table->enum('status', ['Important', 'Urgent', 'Très urgent'])->default('Important'); // Statut de la réclamation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamations');
    }
};
