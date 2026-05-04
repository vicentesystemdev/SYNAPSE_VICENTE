<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('evaluaciones', function (Blueprint $table) {
            if (!Schema::hasColumn('evaluaciones', 'solution_md5')) {
                $table->char('solution_md5', 32)->nullable()->after('flag_hash_eval')->index();
            }

            if (!Schema::hasColumn('evaluaciones', 'metadata_eval')) {
                $table->json('metadata_eval')->nullable()->after('solution_md5');
            }
        });
    }

    public function down(): void {
        Schema::table('evaluaciones', function (Blueprint $table) {
            if (Schema::hasColumn('evaluaciones', 'metadata_eval')) {
                $table->dropColumn('metadata_eval');
            }

            if (Schema::hasColumn('evaluaciones', 'solution_md5')) {
                $table->dropIndex(['solution_md5']);
                $table->dropColumn('solution_md5');
            }
        });
    }
};

