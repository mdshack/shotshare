<?php

namespace App\Http\Controllers;

use App\Enums\ReactionType;
use App\Models\Shot;
use App\Models\ShotReaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ShotController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Shots/Index', [
            'shots' => fn () => $request->user()->shots,
        ]);
    }

    public function show(Request $request, string $id)
    {
        $shot = Shot::whereId($id)->firstOrFail();

        if($shot->parent_shot_id) {
            return to_route("shots.show", [
                'id' => $shot->parent_shot_id,
                'selected_shot_id' => $shot->getKey(),
            ]);
        }

        return Inertia::render('Shots/Show', [
            'shot' => fn () => $shot->fresh(),
            'childShots' => fn () => Shot::whereParentShotId($id)->get(),
            'author' => fn() => $shot->user->only(["id", "name"]),
            'reaction' => fn () => $request->user()->reactions()->whereShotId($id)->first(),
            'reactionCounts' => fn () => ShotReaction::whereShotId($id)
                ->select('reaction', DB::raw('count(*) as count'))
                ->groupBy('reaction')
                ->get()
                ->mapWithKeys(fn($result) => [$result['reaction'] => $result['count']]),
            'showLinks' => config('shots.links'),
        ]);
    }

    public function update()
    {

    }

    public function destroy()
    {

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
        if(!$deleted) {
            ShotReaction::updateOrCreate([
                'shot_id' => $id,
                'user_id' => $userId,
            ], ['reaction' => $reaction]);
        }

        return response(status: Response::HTTP_NO_CONTENT);
    }
}
