<?php

namespace App\Http\Controllers;

use App\Enums\ShotType;
use App\Http\Requests\UploadRequest;
use App\Models\Shot;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        // TODO: Automated testing for ShareX + Shutter integrations

        $type = ShotType::tryFrom($request->get('type')) ?? ShotType::Individual;

        $returnShot = null;

        foreach($request->files->get('images') as $image) {
            $shot = match($type) {
                ShotType::Individual => $this->createShot($request, $type),
                ShotType::Collection => $returnShot ?? $this->createShot($request, $type),
            };

            $returnShot ??= $shot;

            $path = UploadedFile::createFromBase($image)->storePublicly('uploads');
            $info = getimagesize(Storage::path($path));

            $shot->uploads()->create([
                'path' => $path,
                'size_in_bytes' => $image->getSize(),
                "resolution" => $info[0] . "x" . $info[1] . "px",
                "format" => $info["mime"],
            ]);
        }

        return to_route('shots.show', $returnShot->publicIdentifier);
    }

    protected function createShot(Request $request, ShotType $type)
    {
        return $request->user()->shots()->create(array_merge(['type' => $type], $request->only([
            'name',
            'require_logged_in',
            'anonymize',
        ])));
    }
}
