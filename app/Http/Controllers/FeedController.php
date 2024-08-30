<?php

namespace App\Http\Controllers;

use App\Data\ShotData;
use App\Models\Shot;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render("Feed", [
            "shots" => ShotData::collect(Shot::whereHas("user.followers", fn($q) => $q->where("user_followers.follower_id", $request->user()->getKey()))
                ->orderByDesc("created_at")
                ->where("anonymize", false)
                ->cursorPaginate()),
        ]);
    }
}
