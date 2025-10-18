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
        Schema::create('medicaments', function (Blueprint $table) {
            $table->id();
            $table->string('marque')->nullable();
            $table->string('code')->nullable();
            $table->string('dci_temp')->nullable();
            $table->string('forme')->nullable();
            $table->string('voie', 60)->nullable();
            $table->decimal('dosage_val', 10, 3)->nullable();
            $table->string('dosage_temp')->nullable();
            $table->string('presentation')->nullable();
            $table->string('barcode', 32)->nullable();
            $table->string('atc_code', 50)->nullable();
            $table->boolean('exclusion')->default(false);
            $table->decimal('prix_vente_ht', 12, 2)->nullable();
            $table->boolean('actif')->default(true);
            $table->decimal('prix_reference_temp', 12, 2)->nullable();
            $table->enum('statut_temp', ['actif', 'inactif'])->default('actif');
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index('dci_temp');
            $table->index('statut_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicaments');
    }
};
