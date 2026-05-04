<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('periodos', function (Blueprint $table) {
            $table->bigIncrements('id_per');
            $table->string('nombre_per', 60);   // "2025-2"
            $table->string('gestion_per', 20);  // "2025"
            $table->boolean('activo_per')->default(true);
            $table->timestamps();
            $table->unique('nombre_per');
        });
    }
    public function down(): void { Schema::dropIfExists('periodos'); }
};
