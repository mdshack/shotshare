<?php

use App\Models\ShotUpload;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shot_uploads', function (Blueprint $table) {
            $table->string("resolution")->nullable();
            $table->string("size_in_bytes")->nullable();
            $table->string("format")->nullable();
        });

        foreach(ShotUpload::lazy(100) as $upload) {
            $info = getimagesize(Storage::path($upload->path));

            $upload->update([
                "resolution" => $info[0] . "x" . $info[1] . "px",
                "size_in_bytes" => Storage::fileSize($upload->path),
                "format" => $info["mime"],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shot_uploads', function (Blueprint $table) {
            $table->dropColumn("resolution");
            $table->dropColumn("size_in_bytes");
            $table->dropColumn("format");
        });
    }
};
