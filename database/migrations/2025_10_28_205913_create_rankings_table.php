<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rankings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('periodo_id')->nullable();
            $table->unsignedBigInteger('skill_id')->nullable();

            $table->integer('posicion')->default(0);
            $table->decimal('puntaje_total', 12, 2)->default(0.00);

            $table->timestamps();

            $table->unique(['user_id', 'periodo_id', 'skill_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('periodo_id')->references('id_per')->on('periodos')->cascadeOnUpdate()->nullOnDelete();

            $table->index(['periodo_id', 'posicion']);
        });
    }
    public function down(): void { Schema::dropIfExists('rankings'); }
};
