<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShotUpload extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public $timestamps = false;

    public $hidden = ["path"];

    public $appends = [
        "url",
        "size",
    ];

    public function url() : Attribute
    {
        return Attribute::make(
            get: fn() => asset($this->path),
        );
    }

    public function size() : Attribute
    {
        return Attribute::make(
            get: function() {
                $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

                for ($i = 0; $this->size_in_bytes > 1024; $i++) {
                    $this->size_in_bytes /= 1024;
                }

                return round($this->size_in_bytes, 2) . ' ' . $units[$i];
            },
        );
    }

    public function shot()
    {
        return $this->belongsTo(Shot::class);
    }
}
