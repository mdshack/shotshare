<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property int    $id
 * @property string $uuid
 * @property int    $user_id
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Shot extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'uuid',
    ];

    protected $appends = [
        'links',
    ];

    protected static function booted(): void
    {
        static::creating(function (Shot $shot) {
            $shot->forceFill([
                'uuid' => (string) Str::orderedUuid(),
            ]);
        });
    }

    protected function links(): Attribute
    {
        return Attribute::make(
            get: fn ($_, array $attributes) => [
                'url' => config('features.uuid_routes')
                    ? route('shots.show', $attributes['uuid'])
                    : route('shots.show', $attributes['id']),
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

    public function parentShot(): BelongsTo
    {
        return $this->belongsTo(Shot::class, 'parent_shot_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(ShotReaction::class);
    }
}
