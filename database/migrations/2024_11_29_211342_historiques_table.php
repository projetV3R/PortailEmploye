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
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('author');
            $table->string('action');
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            $table->unsignedBigInteger('fiche_fournisseur_id')->nullable(); 
            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiques');
    }
};
