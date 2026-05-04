<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('est_habilidades', function (Blueprint $table) {
            $table->bigIncrements('id_esth');
            $table->unsignedBigInteger('user_id')->unique();

            $table->decimal('theta_global', 8, 4)->nullable();
            $table->json('theta_por_cat')->nullable(); // {WEB:0.6, CRYPTO:0.4,...}

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }
    public function down(): void { Schema::dropIfExists('est_habilidades'); }
};
