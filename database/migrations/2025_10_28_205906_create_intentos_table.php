<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('intentos', function (Blueprint $table) {
            $table->bigIncrements('id_int');
            $table->unsignedBigInteger('evaluacion_id');
            $table->unsignedBigInteger('user_id');

            $table->string('respuesta_flag_int', 255)->nullable();
            $table->boolean('es_correcto_int')->default(false);
            $table->unsignedInteger('nro_intento_int')->default(1);

            $table->dateTime('tiempo_envio_int')->nullable();      // si quieres default: now(), cámbialo a timestamps en código
            $table->unsignedInteger('latencia_seg_int')->nullable();

            $table->json('meta_int')->nullable();
            $table->timestamps();

            $table->foreign('evaluacion_id')->references('id_eval')->on('evaluaciones')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

            $table->index(['user_id','evaluacion_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('intentos'); }
};
