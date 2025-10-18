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
        Schema::create('prestataires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classification_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['Structure Sanitaire', 'Pharmacie']);
            $table->string('denomination');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->boolean('desactive')->default(false);
            $table->timestamps();

            $table->index(['department_id', 'classification_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestataires');
    }
};
