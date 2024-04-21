<?php

namespace App\Http\Controllers;

use App\Enums\ReactionType;
use App\Http\Requests\UpdateShotRequest;
use App\Models\Shot;
use App\Models\ShotReaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        $shot = Shot::wherePublicIdentifier($id)->firstOrFail();

        if ($shot->parent_shot_id) {
            $parentShotId = config('features.uuid_routes')
                // TODO: Don't load parent (perhaps migrate parent_shot_id to be either uuid or id pending settings)
                ? $shot->parentShot->uuid
                : $shot->parent_shot_id;

            return to_route('shots.show', [
                'id' => $parentShotId,
                'selected_shot_id' => $shot->getKey(),
            ]);
        }

        if ($shot->require_logged_in && ! $request->user()) {
            abort(404);
        }

        if ($shot->user_id != $request->user()?->getKey()) {
            $shot->views()->firstOrCreate(['identity' => md5($request->ip())]);
        }

        return Inertia::render('Shots/Show', [
            'shot' => fn () => $shot->fresh(),
            'childShots' => fn () => Shot::whereParentShotId($shot->getKey())->get(),
            'author' => fn () => $shot->anonymize ? null : $shot->user->only(['id', 'name', 'bio', 'display_handle']),
            'reaction' => fn () => $request->user()?->reactions()->whereShotId($shot->getKey())->first(),
            'isFavorite' => fn () => ! is_null($request->user()?->favorites()->whereShotId($shot->getKey())->first()),
            'reactionCounts' => fn () => ShotReaction::whereShotId($shot->getKey())
                ->select('reaction', DB::raw('count(*) as count'))
                ->groupBy('reaction')
                ->get()
                ->mapWithKeys(fn ($result) => [$result['reaction'] => $result['count']]),
            'showLinks' => config('shots.links'),
            'isOwner' => $shot->user_id == $request->user()?->getKey(),
            'views' => fn () => $shot->views()->count(),
        ]);
    }

    public function update(UpdateShotRequest $request, string $id)
    {
        $request->user()->shots()
            ->whereId($id)
            ->update($request->validated());

        return response(status: Response::HTTP_NO_CONTENT);
    }

    public function destroy(Request $request, string $id)
    {
        $shot = Shot::where('user_id', $request->user()->getKey())
            ->whereId($id)
            ->firstOrFail();

        if ($shot) {
            Storage::delete($shot->path);
            $shot->delete();
        }

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

    public function favorite(Request $request, string $id)
    {
        $request->user()->favorites()->firstOrCreate([
            'shot_id' => $id,
        ]);

        return response(status: Response::HTTP_NO_CONTENT);
    }

    public function unfavorite(Request $request, string $id)
    {
        $request->user()->favorites()
            ->where(['shot_id' => $id])
            ->delete();

        return response(status: Response::HTTP_NO_CONTENT);
    }
}
