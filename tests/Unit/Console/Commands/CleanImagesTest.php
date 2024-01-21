<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Shot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CleanImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_cleans_up_shots_and_files()
    {
        Storage::fake();

        $user = User::factory()->create();

        $user->shots()->saveMany(Shot::factory($count = 3)->make());
        for ($i = 0; $i < $count; $i++) {
            Storage::put("uploads/$i.png", 'test');
        }

        $this->artisan('shotshare:clean-images');

        $this->assertEquals(0, Shot::count(), 'it deletes all records');
        $this->assertCount(0, Storage::allFiles('uploads'), 'it deleted all files');
    }

    public function test_it_cleans_up_files_with_missing_shot_records()
    {
        Storage::fake();

        $user = User::factory()->create();

        $shots = Shot::factory(3)->make();

        foreach ($shots as $i => $shot) {
            // Existing
            Storage::put($existing = "uploads/{$i}.png", 'test');
            // Missing
            Storage::put('uploads/'.$i + 100 .'.png', 'test');

            $shot->path = $existing;
        }

        $shots = $user->shots()->saveMany($shots);

        $this->artisan('shotshare:clean-images --only-missing');

        $this->assertCount(3, Storage::allFiles('uploads'), 'it deletes missing images');
    }
}
