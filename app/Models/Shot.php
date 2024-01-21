<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * @property int    $id
 * @property string $uuid
 * @property int    $user_id
 * @property string $name
 * @property string $path
 * @property int    $parent_shot_id
 * @property bool   $require_logged_in
 * @property bool   $anonymize
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

    protected $casts = [
        'require_logged_in' => 'bool',
        'anonymize' => 'bool',
    ];

    protected static function booted(): void
    {
        static::creating(function (Shot $shot) {
            $shot->forceFill([
                'uuid' => (string) Str::orderedUuid(),
            ]);
        });

        static::deleting(function (Shot $shot) {
            try {
                if (! Storage::delete($shot->path)) {
                    throw new Exception('Missing file');
                }
            } catch (Throwable $th) {
                Log::warning('Unable to delete shot', [
                    'path' => $shot->path,
                    'exception' => $th,
                ]);
            }
        });
    }

    protected function links(): Attribute
    {
        return Attribute::make(
            get: fn ($_, array $attributes) => [
                'url' => route('shots.show', $this->publicIdentifier),
                'asset_url' => asset($attributes['path']),
            ],
        );
    }

    protected function publicIdentifier(): Attribute
    {
        return Attribute::make(
            get: fn ($_, array $attributes) => config('features.uuid_routes')
                ? $attributes['uuid']
                : $attributes['id'],
        );
    }

    public function scopeWherePublicIdentifier(Builder $query, string|int $id): void
    {
        if (config('features.uuid_routes')) {
            $query->whereUuid($id);
        } else {
            $query->whereId($id);
        }
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
