<?php

namespace App\Data;

use App\Enums\ShotType;
use App\Models\Shot;
use App\Models\ShotUpload;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class UploadData extends Data
{
    public function __construct(
        public string $url,
        public string $resolution,
        public string $size,
        public string $format,
    ) {}

    public static function fromModel(ShotUpload $upload)
    {
        return new static(
            $upload->url,
            $upload->resolution,
            $upload->size,
            $upload->format,
        );
    }
}
