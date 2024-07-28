<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Enums\ReactionType;
use App\Models\Shot;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ShotReactionController extends Controller
{
    public function index(Request $request, string|int $shotId)
    {
        $shot = Shot::wherePublicIdentifier($shotId)->firstOrFail();

        return [
            "current_user" => $shot->reactions()->whereUserId($request->user()->getKey())->count() > 0,
            "users" => UserData::collect($shot->reactions()->with("user")
                ->whereHas('user.followers', fn($q) => $q->where("follower_id", $request->user()->getKey()))
                ->limit(2)
                ->get()
                ->pluck("user")),
            "count" => $shot->reactions()->whereReaction(ReactionType::Upvote)->count(),
        ];
    }

    public function store(Request $request, string|int $shotId)
    {
        $shot = Shot::wherePublicIdentifier($shotId)->firstOrFail();

        $this->validate($request, [
            'reaction' => ['required', Rule::enum(ReactionType::class)],
        ]);

        // Delete in the event they are reversing an existing reaction
        $deleted = $shot->reactions()
            ->whereUserId($userId = $request->user()->getKey())
            ->whereReaction($reaction = $request->get('reaction'))
            ->delete();

        // They didn't delete anything, lets create their reaction
        if (! $deleted) {
            $shot->reactions()->updateOrCreate([
                'shot_id' => $shotId,
                'user_id' => $userId,
            ], ['reaction' => $reaction]);
        }

        return response(status: Response::HTTP_NO_CONTENT);
    }
}
