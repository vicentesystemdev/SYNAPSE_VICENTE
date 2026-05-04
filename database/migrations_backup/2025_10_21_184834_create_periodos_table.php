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
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigIncrements('id_per');
            $table->string('nombre_per', 40); // p.ej. "2025-2"
            $table->integer('gestion_per');   // 2025
            $table->boolean('activo_per')->default(true);
            $table->unique(['nombre_per','gestion_per']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos');
    }
};
