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
        Schema::create('emission_cotisations', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('mutuelle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('adherent_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date_emission');
            $table->date('periode_debut')->nullable();
            $table->date('periode_fin')->nullable();
            $table->decimal('montant', 12, 2);
            $table->enum('statut', ['brouillon', 'validee', 'annulee'])->default('brouillon');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['mutuelle_id', 'adherent_id'], 'emission_cotisations_mutuelle_adherent_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emission_cotisations');
    }
};
