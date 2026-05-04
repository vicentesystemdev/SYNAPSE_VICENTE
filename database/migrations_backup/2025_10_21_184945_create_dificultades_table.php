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
        Schema::create('dificultades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigIncrements('id_diff');
            $table->unsignedTinyInteger('nivel_diff'); // 1..5
            $table->string('nombre_diff', 40); // Fácil, Medio, Difícil...
            $table->timestamps();
            $table->unique('nivel_diff');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dificultades');
    }
};
