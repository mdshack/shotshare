<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShotView extends Model
{
    protected $primaryKey = null;

    protected $guarded = [];

    public $incrementing = false;

    public $timestamps = false;

    public function shot(): BelongsTo
    {
        return $this->belongsTo(Shot::class);
    }
}
