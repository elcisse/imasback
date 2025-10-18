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
        Schema::create('conventions_entreprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mutuelle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('entreprise_id')->constrained()->cascadeOnDelete();
            $table->string('numero')->unique();
            $table->string('objet')->nullable();
            $table->date('date_signature')->nullable();
            $table->date('date_effet');
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['brouillon', 'actif', 'suspendu', 'clos', 'resilie'])->default('actif');
            $table->decimal('taux_couverture_defaut', 5, 2)->default(0);
            $table->decimal('plafond_annuel_benef', 12, 2)->nullable();
            $table->enum('mode_facturation', ['acte', 'forfait', 'mixte'])->default('acte');
            $table->enum('periodicite_facturation', ['a-la-prestation', 'mensuelle', 'trimestrielle', 'semestrielle', 'annuelle'])->default('mensuelle');
            $table->unsignedInteger('delai_paiement_jours')->default(30);
            $table->unsignedInteger('nombre_beneficiaires')->nullable();
            $table->string('piece_jointe_url', 2048)->nullable();
            $table->string('signee_par_mutuelle')->nullable();
            $table->string('signee_par_entreprise')->nullable();
            $table->json('clauses')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['mutuelle_id', 'entreprise_id', 'date_effet'], 'conventions_entreprises_unique_effet');
            $table->index(['entreprise_id', 'statut'], 'conventions_entreprises_entreprise_statut_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conventions_entreprises');
    }
};
