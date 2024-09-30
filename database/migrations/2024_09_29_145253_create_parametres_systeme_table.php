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
        Schema::create('parametres_systeme', function (Blueprint $table) {
            $table->id();
            $table->string('cle');
            $table->string('valeur')->nullable(); // Pour les emails
            $table->integer('valeur_numerique')->nullable(); // Pour les mois de revision et taille fichier max
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametres_systeme');
    }
};
