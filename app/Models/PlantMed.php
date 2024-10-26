<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PlantMed extends Model implements HasMedia
{
    use HasFactory;
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
        'promotion',
        'sources',
        'is_available',
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
        'is_active',
        'updated_at',
        'description',
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

    public function generateDefaultSourcesUrls()
    {
        $sources = $this->sources ?: [];
        $baseUrl = "https://example.com/plantes/";
        $slug = $this->generateSlug($this->name);

        $defaultSource = [
            'url' => $baseUrl . $slug,
        ];

        if (!in_array($defaultSource, $sources)) {
            $sources[] = $defaultSource;
        }

        $this->sources = $sources;
        $this->save();
    }

    private function generateSlug($name)
    {
        return strtolower(str_replace(' ', '-', $name));
    }

    public static function generateAllDefaultSourcesUrls()
    {
        $plants = self::all();
        foreach ($plants as $plant) {
            $plant->generateDefaultSourcesUrls();
        }
    }
}
