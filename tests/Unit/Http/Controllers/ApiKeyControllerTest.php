<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiKeyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_it_creates_api_keys()
    {
        $response = $this->actingAs($this->user)
            ->post(route('api-keys.store'), ['name' => $name = 'test'])
            ->assertOk();

        $token = $this->user->tokens->first();

        $this->assertEquals($name, $token->name, 'it sets the desired name');
        $this->assertEquals($token->token, hash('sha256', $response->getOriginalContent()['token']), 'it returns correct token value');
    }

    public function test_it_deletes_api_keys()
    {
        $this->user->createToken('test');
        $token = $this->user->tokens()->first();

        $this->actingAs($this->user)
            ->delete(route('api-keys.destroy', $token->id))
            ->assertNoContent();

        $this->assertNull($token->fresh(), 'it deletes token');
    }
}
