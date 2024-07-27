<?php

namespace App\Http\Controllers;

use App\Enums\ShotType;
use App\Http\Requests\UploadRequest;
use App\Models\Shot;
use Illuminate\Http\UploadedFile;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        // TODO: Automated testing for ShareX + Shutter integrations

        $type = ShotType::tryFrom($request->get('type')) ?? ShotType::Individual;

        $returnShot = null;

        if($type === ShotType::Individual) {
            foreach($request->files->get('images') as $image) {
                $shot = $request->user()->shots()->create(array_merge(['type' => $type], $request->only([
                    'title',
                    'require_logged_in',
                    'anonymize',
                ])));

                // return the first shot we create
                $returnShot ??= $shot;

                $shot->uploads()->create([
                    'path' => UploadedFile::createFromBase($image)->storePublicly('uploads')
                ]);
            }
        } else {
            $shot = $request->user()->shots()->create(array_merge(['type' => $type], $request->only([
                'title',
                'require_logged_in',
                'anonymize',
            ])));

            // return the first shot we create
            $returnShot ??= $shot;

            foreach($request->files->get('images') as $image) {
                $shot->uploads()->create([
                    'path' => UploadedFile::createFromBase($image)->storePublicly('uploads')
                ]);
            }
        }

        // foreach ($request->files->get('images') as $image) {

        // }

        // $parentShot = null;

        // foreach ($request->files->get('images') as $i => $image) {
        //     $path = UploadedFile::createFromBase($image)->storePublicly('uploads');

        //     $shot = $request->user()->shots()->create([
        //         'path' => $path,
        //         'parent_shot_id' => $parentShot?->getKey(),
        //     ]);

        //     if ($i === 0) {
        //         $parentShot = $shot;
        //     }
        // }

        // $id = $parentShot->publicIdentifier;

        // if ($request->expectsJson()) {
        //     return response()->json([
        //         'data' => [
        //             'link' => route('shots.show', $id),
        //         ],
        //     ]);
        // }

        return to_route('shots.show', $returnShot->publicIdentifier);
    }
}
