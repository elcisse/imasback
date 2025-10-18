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
        Schema::create('encaissement_cotisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emission_cotisation_id')->constrained('emission_cotisations')->cascadeOnDelete();
            $table->date('date_encaissement');
            $table->decimal('montant', 12, 2);
            $table->string('mode_paiement')->nullable();
            $table->string('reference')->nullable();
            $table->enum('statut', ['en_attente', 'confirme', 'annule'])->default('en_attente');
            $table->timestamps();
            $table->softDeletes();

            $table->index('date_encaissement', 'encaissement_cotisations_date_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encaissement_cotisations');
    }
};
