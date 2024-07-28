<?php

namespace App\Http\Controllers;

use App\Data\CommentData;
use App\Data\ShotData;
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
            abort(404);
        }

        return Inertia::render('Shots/Show', [
            'shot' => fn () => ShotData::fromModel($shot),
            'tab' => fn () => $request->query('tab', null),

            // Lazy Relationships
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
