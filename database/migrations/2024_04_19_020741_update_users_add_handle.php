<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('handle')
                ->nullable()
                ->after('name')
                ->unique();
        });

        foreach(User::all() as $user) {
            $this->setUserHandle($user);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('handle')
                ->nullable(false)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('handle');
        });
    }

    protected function setUserHandle(User $user) : void
    {
        $user->handle = Str::of($user->name)
            ->lower()
            ->replace(" ", ".")
            ->toString();

        // Append numbers until we are unique
        while (User::whereHandle($user->handle)->count() >= 1) {
            $user->handle .= rand(1,9);
        }

        $user->save();
    }
};
