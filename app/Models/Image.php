<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'size',
        'mime_type',
        'imageable_id',
        'imageable_type'
    ];

    public function url(): Attribute
    {
        return Attribute::get(fn() => asset("storage/$this->path"));
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}
