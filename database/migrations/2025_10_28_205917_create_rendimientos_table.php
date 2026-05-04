<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rendimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('categoria_id');

            $table->decimal('r_ema', 6, 4)->default(0.5000);
            $table->unsignedInteger('muestras')->default(0);

            $table->timestamps();

            $table->unique(['user_id','categoria_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('categoria_id')->references('id_cat')->on('categorias')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }
    public function down(): void { Schema::dropIfExists('rendimientos'); }
};
