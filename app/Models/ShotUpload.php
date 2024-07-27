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

    public $appends = ["url"];

    public function url() : Attribute
    {
        return Attribute::make(
            get: fn() => asset($this->path),
        );
    }

    public function shot()
    {
        return $this->belongsTo(Shot::class);
    }
}
