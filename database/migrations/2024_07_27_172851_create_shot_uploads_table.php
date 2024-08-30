<?php

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
        Schema::create('shot_uploads', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Shot::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string("path");
        });

        foreach(Shot::lazy(100) as $shot) {
            $shot->uploads()->create([
                "path" => $shot->path,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shot_uploads');
    }
};
