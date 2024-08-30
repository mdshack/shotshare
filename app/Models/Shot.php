<?php

namespace App\Models;

use App\Enums\ShotType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property string $name
 * @property ShotType $type
 * @property int $parent_shot_id
 * @property bool $require_logged_in
 * @property bool $anonymize
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Shot extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'uuid',
    ];

    protected $appends = [
        'url',
    ];

    protected $attributes = [
        'type' => ShotType::Individual,
    ];

    protected $casts = [
        'type' => ShotType::class,
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
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn() => route('shots.show', $this->publicIdentifier),
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

    public function uploads()
    {
        return $this->hasMany(ShotUpload::class);
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

    public function comments() : MorphMany
    {
        return $this->morphMany(Comment::class, "commentable");
    }
}
