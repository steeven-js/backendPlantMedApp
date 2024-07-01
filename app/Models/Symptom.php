<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Symptom extends Model implements HasMedia
{
    use AsSource;
    use HasFactory;
    use Filterable;
    use InteractsWithMedia;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'image',
        'description',
        'source',
        'is_active',
        'is_prenium'
    ];

    protected $allowedSorts = [
        'name',
        'updated_at',
    ];

    protected $allowedFilters = [
        'name'       => Like::class,
        'updated_at' => Like::class,
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
