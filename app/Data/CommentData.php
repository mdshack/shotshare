<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class CommentData extends Data
{
    public function __construct(
        public int $id,
        public string $contents,
        public Carbon $created_at,
        public Carbon $updated_at,

        public ?UserData $user,
    ) {}
}
