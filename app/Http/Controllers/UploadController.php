<?php

namespace App\Http\Controllers;

use App\Enums\ShotType;
use App\Enums\ShotUploadType;
use App\Http\Requests\UploadRequest;
use App\Models\Shot;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        // TODO: Automated testing for ShareX + Shutter integrations

        $type = ShotType::tryFrom($request->get('type')) ?? ShotType::Individual;

        $returnShot = null;

        foreach($request->files->get('images') ?? [] as $image) {
            $shot = match($type) {
                ShotType::Individual => $this->createShot($request, $type),
                ShotType::Collection => $returnShot ?? $this->createShot($request, $type),
            };

            $returnShot ??= $shot;

            $shot->uploads()->create($this->storeImage($image));
        }

        foreach($request->files->get('videos') ?? [] as $video) {
            $shot = match($type) {
                ShotType::Individual => $this->createShot($request, $type),
                ShotType::Collection => $returnShot ?? $this->createShot($request, $type),
            };

            $returnShot ??= $shot;

            $shot->uploads()->create($this->storeVideo($video));
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

    protected function storeImage(SymfonyUploadedFile $image)
    {
        $this->stripExif($image);

        $path = UploadedFile::createFromBase($image)->storePublicly('uploads');
        $info = getimagesize(Storage::path($path));

        return [
            'path' => $path,
            'size_in_bytes' => $image->getSize(),
            "resolution" => $info[0] . "x" . $info[1] . "px",
            "format" => $info["mime"],
            "type" => ShotUploadType::Image,
        ];
    }

    protected function stripExif(SymfonyUploadedFile $image)
    {
        if(config("features.strip_exif")) return;

        try {
            $img = new \Imagick($realPath = $image->getRealPath());
            $profiles = $img->getImageProfiles("icc", true);

            $img->stripImage();

            if(!empty($profiles)) {
                $img->profileImage("icc", $profiles['icc']);
            }

            $img->writeImage($image);

            $img->clear();
            $img->destroy();
        } catch(Throwable $th) {
            Log::error("Failed to strip exif data", [
                "path" => $realPath,
                "previous" => $th,
            ]);
        }
    }

    protected function storeVideo(SymfonyUploadedFile $video)
    {
        $lowBitrateFormat  = (new X264)->setKiloBitrate(500);
        $midBitrateFormat  = (new X264)->setKiloBitrate(1500);
        $highBitrateFormat = (new X264)->setKiloBitrate(3000);

        $preprocessedPath = UploadedFile::createFromBase($video)->store('preprocessed');
        $path = "uploads/" . explode('.', basename($preprocessedPath))[0] . ".m3u8";

        FFMpeg::fromDisk(config("filesystems.default"))
            ->open($preprocessedPath)
            ->exportForHLS()
            ->addFormat($lowBitrateFormat)
            ->addFormat($midBitrateFormat)
            ->addFormat($highBitrateFormat)
            ->save($path);

        Storage::delete($preprocessedPath);

        return [
            'path' => $path,
            "type" => ShotUploadType::Video,
        ];
    }
}
