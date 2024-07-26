<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class UploadController extends Controller
{
    public function create()
    {
        return Inertia::render('Upload');
    }

    public function store(UploadRequest $request)
    {
        \Log::debug("hap1");
        \Log::debug($request->getContent());
        \Log::debug($request->keys());
        \Log::debug($_FILES);

        $parentShot = null;

        foreach (Arr::wrap($request->files->get('images')) as $i => $image) {
            \Log::debug("hap2");
            $path = UploadedFile::createFromBase($image)->storePublicly('uploads');

            $shot = $request->user()->shots()->create([
                'path' => $path,
                'parent_shot_id' => $parentShot?->getKey(),
            ]);

            if ($i === 0) {
                $parentShot = $shot;
            }
        }

        $id = $parentShot->publicIdentifier;

        if ($request->expectsJson()) {
            return response()->json([
                'data' => [
                    'link' => route('shots.show', $id),
                ],
            ]);
        }

        return to_route('shots.show', $id);
    }
}
