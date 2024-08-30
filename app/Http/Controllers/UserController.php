<?php

namespace App\Http\Controllers;

use App\Data\ShotData;
use App\Data\UserData;
use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function show(Request $request, string $handle)
    {
        $user = User::whereHandle($handle)->firstOrFail();

        return Inertia::render("Users/Show", [
            'user' => UserData::from($user),
            'shots' => ShotData::collect($user->shots()
                ->orderByDesc("created_at")
                ->where("anonymize", false)
                ->cursorPaginate()),
            'isFollowing' => $user->followers()->whereFollowerId($request->user()->getKey())->count() > 0
        ]);
    }

    public function follow(Request $request, string $handle)
    {
        $user = User::whereHandle($handle)->firstOrFail();

        $user->followers()->attach([$request->user()->getKey()]);
    }

    public function unfollow(Request $request, string $handle)
    {
        $user = User::whereHandle($handle)->firstOrFail();

        $user->followers()->detach([$request->user()->getKey()]);
    }
}
