<?php

use App\Models\Shot;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shots', function (Blueprint $table) {
            $table->uuid()->after('id')->index();
        });

        Shot::all()->each(fn ($shot) => $shot->forceFill([
            'uuid' => Str::orderedUuid(),
        ])->save());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shots', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
