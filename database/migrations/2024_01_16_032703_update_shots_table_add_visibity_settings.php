<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shots', function (Blueprint $table) {
            $table->boolean('require_logged_in')
                ->after("parent_shot_id")
                ->nullable()
                ->default(false);

            $table->boolean('anonymize')
                ->after("require_logged_in")
                ->nullable()
                ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shots', function (Blueprint $table) {
            $table->dropColumn([
                'require_logged_in',
                'anonymize',
            ]);
        });
    }
};
