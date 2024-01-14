<?php

namespace App\Http\Controllers;

use App\Enums\ReactionType;
use App\Http\Requests\UpdateShotRequest;
use App\Models\Shot;
use App\Models\ShotReaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ShotController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Shots/Index', [
            'shots' => fn () => $request->user()->shots()
                ->orderByDesc('id')
                ->whereNull('parent_shot_id')
                ->with('childShots')
                ->with('reactions', fn ($reactionQuery) => $reactionQuery
                    ->select('reaction', DB::raw('count(*) as count'), 'shot_id')
                    ->groupBy('reaction', 'shot_id'))
                ->get()
                ->map(fn ($shot) => array_merge($shot->toArray(), [
                    'reactions' => $shot['reactions']
                        ->mapWithKeys(fn ($result) => [$result['reaction'] => $result['count']]),
                ])),
        ]);
    }

    public function show(Request $request, string $id)
    {
        $shot = (config('features.uuid_routes')
            ? Shot::whereUuid($id)
            : Shot::whereId($id))->firstOrFail();

        if ($shot->parent_shot_id) {
            return to_route('shots.show', [
                'id' => $shot->parent_shot_id,
                'selected_shot_id' => $shot->getKey(),
            ]);
        }

        return Inertia::render('Shots/Show', [
            'shot' => fn () => $shot->fresh(),
            'childShots' => fn () => Shot::whereParentShotId($shot->getKey())->get(),
            'author' => fn () => $shot->user->only(['id', 'name']),
            'reaction' => fn () => $request->user()?->reactions()->whereShotId($shot->getKey())->first(),
            'reactionCounts' => fn () => ShotReaction::whereShotId($shot->getKey())
                ->select('reaction', DB::raw('count(*) as count'))
                ->groupBy('reaction')
                ->get()
                ->mapWithKeys(fn ($result) => [$result['reaction'] => $result['count']]),
            'showLinks' => config('shots.links'),
        ]);
    }

    public function update(UpdateShotRequest $request, string $id)
    {
        Shot::where('user_id', $request->user()->getKey())
            ->whereId($id)
            ->update($request->validated());

        return response(status: Response::HTTP_NO_CONTENT);
    }

    public function destroy(Request $request, string $id)
    {
        Shot::where('user_id', $request->user()->getKey())
            ->whereId($id)
            ->delete();

        return response(status: Response::HTTP_NO_CONTENT);
    }

    public function react(Request $request, string $id)
    {
        $this->validate($request, [
            'reaction' => ['required', Rule::enum(ReactionType::class)],
        ]);

        // Delete in the event they are reversing an existing reaction
        $deleted = ShotReaction::whereShotId($id)
            ->whereUserId($userId = $request->user()->getKey())
            ->whereReaction($reaction = $request->get('reaction'))
            ->delete();

        // They didn't delete anything, lets create their reaction
        if (! $deleted) {
            ShotReaction::updateOrCreate([
                'shot_id' => $id,
                'user_id' => $userId,
            ], ['reaction' => $reaction]);
        }

        return response(status: Response::HTTP_NO_CONTENT);
    }
}
