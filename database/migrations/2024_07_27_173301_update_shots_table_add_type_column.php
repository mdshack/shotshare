<?php

use App\Enums\ShotType;
use App\Models\Shot;
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
            $table->string("type")
                ->after("name")
                ->nullable();
        });

        Shot::whereNull("type")->update([
            "type" => ShotType::Individual
        ]);

        Schema::table('shots', function (Blueprint $table) {
            $table->string("type")->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shots', function (Blueprint $table) {
            $table->dropColumn("type");
        });
    }
};
