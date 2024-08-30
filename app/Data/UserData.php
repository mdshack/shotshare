<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Illuminate\Support\Str;

class UserData extends Data
{
    public function __construct(
        public string|int $id,
        public string $name,
        public string $handle,
        public Carbon $created_at,
    ) {
        $this->handle = Str::start($this->handle, "@");
    }
}
