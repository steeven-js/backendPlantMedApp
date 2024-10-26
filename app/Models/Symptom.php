<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Symptom extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'image',
        'description',
        'sources',
        'is_active',
        'is_premium'
    ];

    protected $casts = [
        'images' => 'array',
        'sources' => 'array',
        'symptoms' => 'array',
        'is_active' => 'boolean',
        'is_available' => 'boolean',
    ];

    protected $allowedSorts = [
        'name',
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
