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
        Schema::create('lettres_garantie', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('mutuelle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prestataire_id')->constrained()->cascadeOnDelete();
            $table->foreignId('adherent_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ayant_droit_id')->nullable()->constrained('ayants_droit')->nullOnDelete();
            $table->date('date_emission');
            $table->date('date_validite')->nullable();
            $table->enum('statut', ['utilisee', 'annulee', 'brouillon'])->default('brouillon');
            $table->decimal('taux', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['mutuelle_id', 'prestataire_id'], 'lettres_garantie_mutuelle_prestataire_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lettres_garantie');
    }
};
