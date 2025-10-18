<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestation_offerte_lignes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('code')->nullable();
            $table->decimal('tarif', 12, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestation_offerte_lignes');
    }
};
