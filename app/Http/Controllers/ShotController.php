<?php

namespace App\Http\Controllers;

use App\Data\CommentData;
use App\Data\ShotData;
use App\Data\UserData;
use App\Enums\ReactionType;
use App\Http\Requests\UpdateShotRequest;
use App\Models\Comment;
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
    public function show(Request $request, string $id)
    {
        $shot = Shot::with(['user', 'uploads'])
            ->wherePublicIdentifier($id)
            ->firstOrFail();

        if ($shot->require_logged_in && ! $request->user()) {
            return to_route("login");
        }

         return Inertia::render('Shots/Show', [
            'shot' => fn () => ShotData::fromModel($shot),
            'tab' => fn () => $request->query('tab', null),

            // Lazy Relationships
            'reactions' => Inertia::lazy(fn() => [
                "users" => UserData::collect($shot->reactions()->with("user")
                    ->whereHas('user.followers', fn($q) => $q->where("follower_id", $request->user()->getKey()))
                    ->limit(2)
                    ->get()
                    ->pluck("user")),
                "count" => $shot->reactions()->whereReaction(ReactionType::Upvote)->count(),
            ]),
            'comments' => Inertia::lazy(fn() => CommentData::collect(Comment::with("user")
                ->whereCommentableType(Shot::class)
                ->whereCommentableId($shot->getKey())
                ->orderByDesc("created_at")
                ->cursorPaginate(cursorName: "comments_cursor")))
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
        $shot = Shot::where('user_id', $request->user()->getKey())
            ->whereId($id)
            ->firstOrFail();

        if ($shot) {
            Storage::delete($shot->path);
            $shot->delete();
        }

        return response(status: Response::HTTP_NO_CONTENT);
    }
}
