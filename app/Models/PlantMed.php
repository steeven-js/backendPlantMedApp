<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class PlantMed extends Model implements HasMedia
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'image',
        'images',
        'is_featured',
        'is_best_seller',
        'is_active',
        'symptoms',
        'description',
        'habitat',
        'propriete',
        'usageInterne',
        'usageExterne',
        'precaution',
        'sources',
        'is_available'
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
        'is_active',
        'updated_at',
        'description',
    ];

    protected $allowedFilters = [
        'id'             => Like::class,
        'name'           => Like::class,
        'description'    => Like::class,
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('images');
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }

    // obtenir les url des images de la collection images
    public function getImagesAttribute()
    {
        return $this->getMedia('images')->map(function ($item) {
            return $item->getUrl();
        });

        // Inclure les URLs des images multiples
        $mediaItems = $plantmed->getMedia('images');
        $urls = $mediaItems->map(function ($item) {
            return $item->getUrl();
        })->toArray();

        // Enregistrer dans images le tableau des URLs
        $plantmed->images = $urls;

        // Sauvegarder les données
        $plantmed->save();
    }
}
