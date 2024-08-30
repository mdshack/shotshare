<?php

namespace Database\Factories;

use App\Enums\ShotType;
use App\Models\Shot;
use App\Models\ShotUpload;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shot>
 */
class ShotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(asText: true),
            'type' => rand(1,10) > 8
                ? ShotType::Collection
                : ShotType::Individual,
            'created_at' => $time = now()->subSeconds(rand(120, 10000000)),
            'updated_at' => $time,
        ];
    }

    public function withUpload()
    {
        return $this->afterCreating(fn(Shot $shot) => $shot->type === ShotType::Collection
            ? $shot->uploads()->saveMany(ShotUpload::factory(rand(2,5))->make())
            : $shot->uploads()->save(ShotUpload::factory()->make()));
    }
}
