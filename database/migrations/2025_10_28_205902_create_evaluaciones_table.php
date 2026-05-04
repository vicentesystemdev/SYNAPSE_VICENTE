<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->bigIncrements('id_eval');

            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('dificultad_id');
            $table->unsignedBigInteger('periodo_id')->nullable();
            $table->unsignedBigInteger('docente_user_id')->nullable();

            $table->string('titulo_eval', 150);
            $table->text('descripcion_eval')->nullable();

            $table->decimal('puntaje_base_eval', 10, 2)->default(100.00);
            $table->dateTime('fecha_inicio_eval')->nullable();
            $table->dateTime('fecha_fin_eval')->nullable();

            $table->char('flag_hash_eval', 32)->nullable(); // nullable para permitir evaluaciones no-CTF
            $table->unsignedSmallInteger('estado_eval')->default(2); // 1=borrador,2=publicada,...

            $table->timestamps();

            $table->foreign('categoria_id')->references('id_cat')->on('categorias')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('dificultad_id')->references('id_dif')->on('dificultades')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('periodo_id')->references('id_per')->on('periodos')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('docente_user_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();

            $table->index(['categoria_id','dificultad_id','estado_eval']);
        });
    }
    public function down(): void { Schema::dropIfExists('evaluaciones'); }
};
