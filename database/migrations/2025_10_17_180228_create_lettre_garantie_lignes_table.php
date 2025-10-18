<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lettre_garantie_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lettre_garantie_id')->constrained('lettres_garantie')->cascadeOnDelete();
            $table->foreignId('prestation_offerte_ligne_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['lettre_garantie_id', 'prestation_offerte_ligne_id'], 'lettre_garantie_lignes_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lettre_garantie_lignes');
    }
};
