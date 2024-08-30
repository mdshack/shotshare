<?php

namespace Database\Factories;

use App\Enums\ReactionType;
use App\Enums\ShotType;
use App\Models\Shot;
use App\Models\ShotUpload;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShotReaction>
 */
class ShotReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->getKey(),
            'shot_id' => Shot::inRandomOrder()->first()->getKey(),
            'reaction' => ReactionType::Upvote,
        ];
    }
}
