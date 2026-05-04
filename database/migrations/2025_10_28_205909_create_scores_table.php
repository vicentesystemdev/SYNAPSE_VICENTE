<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('evaluacion_id');

            $table->decimal('puntaje', 10, 2)->default(0.00);
            $table->decimal('porcentaje', 5, 2)->default(0.00);
            $table->json('calculo_meta')->nullable();

            $table->timestamps();

            $table->unique(['user_id','evaluacion_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('evaluacion_id')->references('id_eval')->on('evaluaciones')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }
    public function down(): void { Schema::dropIfExists('scores'); }
};
