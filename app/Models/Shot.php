<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property int    $id
 * @property int    $user_id
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Shot extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $appends = [
        'url'
    ];

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($_, array $attributes) => asset($attributes['path']),
        );
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
