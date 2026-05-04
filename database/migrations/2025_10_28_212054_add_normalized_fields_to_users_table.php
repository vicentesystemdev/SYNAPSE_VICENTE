<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users','app_usu')) {
                $table->string('app_usu', 80)->nullable()->after('name');
            }
            if (!Schema::hasColumn('users','apm_usu')) {
                $table->string('apm_usu', 80)->nullable()->after('app_usu');
            }
            if (!Schema::hasColumn('users','activo_usu')) {
                $table->boolean('activo_usu')->default(true)->after('password');
            }
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users','activo_usu')) $table->dropColumn('activo_usu');
            if (Schema::hasColumn('users','apm_usu'))   $table->dropColumn('apm_usu');
            if (Schema::hasColumn('users','app_usu'))   $table->dropColumn('app_usu');
        });
    }
};
