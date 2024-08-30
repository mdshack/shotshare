<?php

namespace App\Http\Controllers;

use App\Data\ShotData;
use App\Models\Shot;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExploreController extends Controller
{
    public function __invoke()
    {
        return Inertia::render("Explore", [
            "shots" => ShotData::collect(Shot::orderByDesc("created_at")->cursorPaginate()),
        ]);
    }
}
