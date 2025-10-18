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
        Schema::create('conventions_pharmacies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mutuelle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prestataire_id')->constrained()->cascadeOnDelete();
            $table->string('numero')->unique();
            $table->string('objet')->nullable();
            $table->date('date_signature')->nullable();
            $table->date('date_effet');
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['brouillon', 'actif', 'suspendu', 'clos', 'resilie'])->default('actif');
            $table->decimal('taux_remise_medicament', 5, 2)->nullable();
            $table->decimal('taux_couverture_defaut', 5, 2)->default(0);
            $table->decimal('plafond_annuel_benef', 12, 2)->nullable();
            $table->enum('mode_facturation', ['acte', 'forfait', 'mixte'])->default('acte');
            $table->enum('periodicite_facturation', ['a-la-prestation', 'mensuelle', 'trimestrielle', 'semestrielle', 'annuelle'])->default('mensuelle');
            $table->unsignedInteger('delai_paiement_jours')->default(30);
            $table->string('piece_jointe_url', 2048)->nullable();
            $table->string('signee_par_mutuelle')->nullable();
            $table->string('signee_par_prestataire')->nullable();
            $table->json('clauses')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['mutuelle_id', 'prestataire_id', 'date_effet'], 'conventions_pharmacies_mutuelle_prestataire_effet_unique');
            $table->index(['prestataire_id', 'statut'], 'conventions_pharmacies_prestataire_statut_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conventions_pharmacies');
    }
};
