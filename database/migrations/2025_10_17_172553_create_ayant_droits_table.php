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
        Schema::create('ayants_droit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_id')->constrained()->cascadeOnDelete();
            $table->enum('lien', ['conjoint', 'enfant', 'parent']);
            $table->string('prenom');
            $table->string('nom');
            $table->date('date_naissance')->nullable();
            $table->string('sexe', 10)->nullable();
            $table->enum('statut', ['actif', 'suspendu'])->default('actif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['adherent_id', 'statut'], 'ayants_droit_adherent_statut_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayants_droit');
    }
};
