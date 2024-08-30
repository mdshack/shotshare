<?php

use App\Enums\ShotUploadType;
use App\Models\ShotUpload;
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
        Schema::table('shot_uploads', function (Blueprint $table) {
            $table->string("type")->after("shot_id")->nullable();
            $table->string("preview_path")->after("path")->nullable();
            $table->timestamp("processed_at")->nullable();
        });

        ShotUpload::where("id", ">", 0)->update([
            "type" => ShotUploadType::Image,
        ]);

        Schema::table('shot_uploads', function (Blueprint $table) {
            $table->string("type")->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shot_uploads', function (Blueprint $table) {
            $table->dropColumn([
                "type",
                "preview_path",
                "processed_at",
            ]);
        });
    }
};
