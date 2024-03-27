<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\UploadedFile;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $parentShot = null;

        foreach ($request->files->get('images') as $i => $image) {
            $imageInfo = getimagesize($image->getPathname());
            $path = UploadedFile::createFromBase($image)->storePublicly('uploads');

            $shot = $request->user()->shots()->create([
                'path' => $path,
                'parent_shot_id' => $parentShot?->getKey(),
                'width' => $imageInfo[0] ?? null,
                'height' => $imageInfo[1] ?? null,
                'type' => $imageInfo['mime'] ?? null,
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
