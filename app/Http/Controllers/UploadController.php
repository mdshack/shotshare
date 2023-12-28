<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\UploadedFile;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        // TODO: Add multi-image view capabilities
        // foreach($request->files->get("images") as $image) {
        //     UploadedFile::createFromBase($image)->store('uploads');
        // }

        $path = UploadedFile::createFromBase($request->files->get('images')[0])->storePublicly('uploads');

        $shot = $request->user()->shots()->create([
            'path' => $path,
        ]);

        return to_route('shots.show', $shot->getKey());
    }
}
