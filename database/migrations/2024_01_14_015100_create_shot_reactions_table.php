<?php

use App\Models\Shot;
use App\Models\User;
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
        Schema::create('shot_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Shot::class);
            $table->foreignIdFor(User::class);
            $table->string("reaction")->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shot_reactions');
    }
};
