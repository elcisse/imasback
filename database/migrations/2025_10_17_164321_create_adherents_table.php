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
        Schema::create('adherents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mutuelle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('entreprise_id')->constrained()->cascadeOnDelete();
            $table->string('matricule');
            $table->string('prenom');
            $table->string('nom');
            $table->string('sexe', 10)->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('numero_cni')->nullable();
            $table->string('etat_civil', 20)->nullable();
            $table->foreignId('commune_id')->nullable()->constrained()->nullOnDelete();
            $table->string('telephone', 30)->nullable();
            $table->string('email')->nullable();
            $table->date('date_adhesion')->nullable();
            $table->enum('statut', ['actif', 'suspendu', 'radie'])->default('actif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['mutuelle_id', 'entreprise_id'], 'adherents_mutuelle_entreprise_index');
            $table->index('matricule');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adherents');
    }
};
