<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'image',
        'promotion',
    ];

    protected $allowedSorts = [
        'promotion',
        'updated_at',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }
}
