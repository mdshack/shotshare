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
            $path = UploadedFile::createFromBase($image)->storePublicly('uploads');

            $shot = $request->user()->shots()->create([
                'path' => $path,
                'parent_shot_id' => $parentShot?->getKey(),
            ]);

            if ($i === 0) {
                $parentShot = $shot;
            }
        }

        return to_route('shots.show', config('features.uuid_routes')
            ? $parentShot?->uuid
            : $parentShot?->getKey());
    }
}
