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
        Schema::create('bon_pharmacie_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_pharmacie_id')->constrained('bons_pharmacie')->cascadeOnDelete();
            $table->unsignedInteger('numero_ordre');
            $table->foreignId('medicament_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantite', 10, 2)->default(1);
            $table->decimal('prix_unitaire', 12, 2);
            $table->decimal('montant', 12, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['bon_pharmacie_id', 'numero_ordre'], 'bon_pharmacie_lignes_unique_numero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_pharmacie_lignes');
    }
};
