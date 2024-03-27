<?php

use App\Models\Shot;
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
        Schema::table('shots', function (Blueprint $table) {
            $table->string('type')->after('path')->nullable();
            $table->integer('width')->after('type')->nullable();
            $table->integer('height')->after('width')->nullable();
        });

        foreach (Storage::allFiles('uploads') as $file) {
            $path = Storage::path($file);
            $imageInfo = getimagesize($path);

            Shot::wherePath($file)->update([
                'width' => $imageInfo[0] ?? null,
                'height' => $imageInfo[1] ?? null,
                'type' => $imageInfo['mime'] ?? null,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shots', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'width',
                'height',
            ]);
        });
    }
};
