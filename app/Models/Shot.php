<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'links',
    ];

    protected function links(): Attribute
    {
        return Attribute::make(
            get: fn ($_, array $attributes) => [
                'url' => route('shots.show', $attributes['id']),
                'asset_url' => asset($attributes['path']),
            ],
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function childShots(): HasMany
    {
        return $this->hasMany(Shot::class, 'parent_shot_id');
    }
}
