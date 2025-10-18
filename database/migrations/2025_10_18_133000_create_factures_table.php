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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('mutuelle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prestataire_id')->constrained()->cascadeOnDelete();
            $table->date('date_facture');
            $table->date('date_echeance')->nullable();
            $table->decimal('montant_ht', 12, 2)->default(0);
            $table->decimal('montant_couvert', 12, 2)->default(0);
            $table->decimal('montant_restant', 12, 2)->default(0);
            $table->enum('statut', ['recue', 'en_litige', 'validee', 'reglee', 'annulee'])->default('recue');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['mutuelle_id', 'prestataire_id'], 'factures_mutuelle_prestataire_index');
            $table->index('date_facture');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
