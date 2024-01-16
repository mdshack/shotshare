<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Shot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_it_uploads_shots()
    {
        Storage::fake();

        [$parent, $child] = [
            UploadedFile::fake()->image('fileA.jpg'),
            UploadedFile::fake()->image('fileB.png'),
        ];

        $this
            ->actingAs($this->user)
            ->post(route('upload'), [
                'images' => [$parent, $child],
            ]);

        Storage::assertExists($parentPath = 'uploads/'.$parent->hashName());
        Storage::assertExists($childPath = 'uploads/'.$child->hashName());

        $parentRecord = Shot::wherePath($parentPath)->first();
        $childRecord = Shot::wherePath($childPath)
            ->whereParentShotId($parentRecord->id)
            ->first();

        $this->assertNotNull($parentRecord, 'it created parent record');
        $this->assertNotNull($childRecord, 'it created child record');
    }

    public function test_it_returns_json()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('fileA.jpg');

        $response = $this
            ->actingAs($this->user)
            ->post(route('api.upload'), [
                'images' => [$image],
            ], [
                'accept' => 'application/json',
            ]);

        $shot = Shot::first();

        $this->assertEquals([
            'data' => [
                'link' => $shot->links['url'],
            ],
        ], json_decode($response->getContent(), true), 'it returns json');
    }
}
