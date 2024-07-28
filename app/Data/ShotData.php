<?php

namespace App\Data;

use App\Enums\ShotType;
use App\Models\Shot;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ShotData extends Data
{
    public function __construct(
        public string|int $id,
        public ?string $name,
        public string $url,
        public ShotType $type,
        public Carbon $created_at,
        public Carbon $updated_at,
        public bool $is_owner,

        #[DataCollectionOf(UploadData::class)]
        public $uploads,
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
            $shot->url,
            $shot->type,
            $shot->created_at,
            $shot->updated_at,
            $shot->user_id === request()->user()?->id,
            $shot->uploads,
            $shot->anonymize
                ? null
                : UserData::from($shot->user),
        );
    }
}
