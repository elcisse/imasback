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
        Schema::create('antennes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mutuelle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('nom_antenne');
            $table->string('adresse');
            $table->string('telephone');
            $table->boolean('desactive')->default(false);
            $table->timestamps();

            $table->unique(['mutuelle_id', 'nom_antenne']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antennes');
    }
};
