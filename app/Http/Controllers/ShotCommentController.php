<?php

namespace App\Http\Controllers;

use App\Data\CommentData;
use App\Models\Comment;
use App\Models\Shot;
use Illuminate\Http\Request;

class ShotCommentController extends Controller
{
    public function store(Request $request, string|int $shotId)
    {
        $shot = Shot::wherePublicIdentifier($shotId)->firstOrFail();

        $validated = $this->validate($request, [
            'contents' => ["string", "required", "min:1", "max:500"],
        ]);

        $shot->comments()->create(array_merge([
            "user_id" => $request->user()->getKey(),
        ], $validated));
    }
}
