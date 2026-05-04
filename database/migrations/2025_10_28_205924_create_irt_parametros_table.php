<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('irt_parametros', function (Blueprint $table) {
            $table->bigIncrements('id_irt');
            $table->unsignedBigInteger('evaluacion_id')->unique();

            $table->decimal('a_discriminacion', 6, 3)->default(1.000); // 2PL
            $table->decimal('b_dificultad', 6, 3)->default(0.000);
            $table->decimal('c_azar', 6, 3)->nullable();               // si usas 3PL

            $table->timestamps();

            $table->foreign('evaluacion_id')->references('id_eval')->on('evaluaciones')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }
    public function down(): void { Schema::dropIfExists('irt_parametros'); }
};
