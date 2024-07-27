<?php

namespace App\Data;

use App\Enums\ShotType;
use App\Models\Shot;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class ShotData extends Data
{
    public function __construct(
        public string|int $id,
        public ?string $name,
        public ShotType $type,
        public Carbon $created_at,
        public Carbon $updated_at,

        public array $uploads,
        public ?UserData $author,
    ) {}

    public static function fromModel(Shot $shot)
    {
        $shot->loadMissing([
            'user',
            'uploads',
        ]);

        return new static(
            $shot->publicIdentifier,
            $shot->name,
            $shot->type,
            $shot->created_at,
            $shot->updated_at,
            $shot->uploads->pluck("url")->toArray(),
            $shot->anonymize
                ? null
                : UserData::from($shot->user),
        );
    }
}
