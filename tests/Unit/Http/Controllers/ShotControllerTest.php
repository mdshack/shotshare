<?php

namespace Tests\Unit\Http\Controllers;

use App\Enums\ReactionType;
use App\Models\Shot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ShotControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_index_shows_active_users_shots()
    {
        [$shot, $childShot] = $this->createShot();

        $this->actingAs($this->user)
            ->get(route('shots.index'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Shots/Index')
                ->has('shots', 1)
                ->has('shots', fn (Assert $shotsProp) => $shotsProp
                    ->where('0.id', $shot->id)
                    // userA + userB = 2 upvotes
                    ->where('0.reactions.upvote', 3)
                    // userC = 1 downvote
                    ->where('0.reactions.downvote', 1)
                    // Single child shot
                    ->has('0.child_shots', 1)
                    // Shot matches expected child
                    ->where('0.child_shots.0.id', $childShot->getKey()))
            );

    }

    public function test_show_shows_desired_shot_for_id()
    {
        [$shot, $childShot] = $this->createShot();
        config()->set('features.uuid_routes', false);

        $this->actingAs($this->user)
            ->get(route('shots.show', $shot->id))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Shots/Show')
                ->where('shot.id', $shot->id)
                ->has('childShots', 1)
                ->has('childShots', fn (Assert $shotProp) => $shotProp
                    ->where('0.id', $childShot->id))
                ->where('author', [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ])
                ->where('reaction.reaction', ReactionType::Upvote->value)
                ->where('reactionCounts.upvote', 3)
                ->where('reactionCounts.downvote', 1)
                ->where('showLinks', config('shots.links'))
            );
    }

    public function test_show_shows_desired_shot_for_uuid()
    {
        [$shot, $_] = $this->createShot(true);
        config()->set('features.uuid_routes', true);

        $this->actingAs($this->user)
            ->get(route('shots.show', $shot->uuid))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Shots/Show')
                ->where('shot.id', $shot->id)
                ->where('shot.uuid', $shot->uuid));
    }

    public function test_show_redirects_to_parent_shot_for_id()
    {
        config()->set('features.uuid_routes', false);
        [$shot, $childShot] = $this->createShot();

        $this->actingAs($this->user)
            ->get(route('shots.show', $childShot->id))
            ->assertRedirect(route('shots.show', [
                'id' => $shot->id,
                'selected_shot_id' => $childShot->id,
            ]));
    }

    public function test_show_redirects_to_parent_shot_for_uuid()
    {
        config()->set('features.uuid_routes', true);
        [$shot, $childShot] = $this->createShot();

        $this->actingAs($this->user)
            ->get(route('shots.show', $childShot->uuid))
            ->assertRedirect(route('shots.show', [
                'id' => $shot->uuid,
                'selected_shot_id' => $childShot->id,
            ]));
    }

    public function test_update_updates_shots_name()
    {
        [$shot, $_] = $this->createShot(true);

        $this->actingAs($this->user)
            ->patch(route('shots.update', $shot->id), [
                'name' => $name = 'updated name',
            ])
            ->assertNoContent();

        $this->assertEquals($name, $shot->fresh()->name, 'it updates shot name');
    }

    public function test_destroy_deletes_shot()
    {
        [$shot, $_] = $this->createShot(true);

        $this->actingAs($this->user)
            ->delete(route('shots.destroy', $shot->id))
            ->assertNoContent();

        $this->assertNull($shot->fresh(), 'it deletes shot');
    }

    public function test_users_can_react_to_a_shot()
    {
        [$shot, $_] = $this->createShot(true);

        $this->actingAs($this->user)
            ->post(route('shots.react', $shot->id), [
                'reaction' => $react = ReactionType::Upvote->value,
            ])
            ->assertNoContent();

        $this->assertCount(1, $reactions = $shot->reactions()->get(), 'it create upvote reaction');
        $this->assertEquals($this->user->getKey(), $reactions[0]['user_id']);
        $this->assertEquals($react, $reactions[0]['reaction']);

        $this->actingAs($this->user)
            ->post(route('shots.react', $shot->id), [
                'reaction' => $react = ReactionType::Downvote->value,
            ])
            ->assertNoContent();

        $this->assertCount(1, $reactions = $shot->reactions()->get(), 'it changes reaction to downvote');
        $this->assertEquals($this->user->getKey(), $reactions[0]['user_id']);
        $this->assertEquals($react, $reactions[0]['reaction']);

        $this->actingAs($this->user)
            ->post(route('shots.react', $shot->id), [
                'reaction' => $react = ReactionType::Downvote->value,
            ])
            ->assertNoContent();

        $this->assertCount(0, $reactions = $shot->reactions()->get(), 'it toggles existing reaction');
    }

    protected function createShot(bool $onlyShot = false): array
    {
        $shot = $this->user->shots()->save(Shot::factory()->make());

        if (! $onlyShot) {
            // Create "childShots"
            $childShot = $this->user->shots()->save(Shot::factory()->make([
                'parent_shot_id' => $shot->getKey(),
            ]));

            // Create "reactions"
            [$userA, $userB, $userC] = User::factory(3)->create();
            $shot->reactions()->create([
                'user_id' => $this->user->getKey(),
                'reaction' => ReactionType::Upvote->value,
            ]);

            $shot->reactions()->create([
                'user_id' => $userA->getKey(),
                'reaction' => ReactionType::Upvote->value,
            ]);

            $shot->reactions()->create([
                'user_id' => $userB->getKey(),
                'reaction' => ReactionType::Upvote->value,
            ]);

            $shot->reactions()->create([
                'user_id' => $userC->getKey(),
                'reaction' => ReactionType::Downvote->value,
            ]);
        }

        return [
            $shot,
            $childShot ?? null,
        ];
    }
}
