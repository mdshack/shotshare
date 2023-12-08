<?php

namespace App\Http\Controllers;

use App\Models\Shot;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShotController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Shots/Index', [
            'shots' => fn () => $request->user()->shots
        ]);
    }

    public function show(string $id)
    {
        return Inertia::render('Shots/Show', [
            'shot' => fn () => Shot::whereId($id)->firstOrFail()
        ]);
    }
}
