<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class PlantMed extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    // $table->text('habitat')->nullable();
    // $table->text('propriete')->nullable();
    // $table->text('usageInterne')->nullable();
    // $table->text('usageExterne')->nullable();
    // $table->text('precaution')->nullable();
    // $table->json('sources')->nullable();

    protected $hidden = [
        'created_at',
        'updated_at',
        'is_active',
        'is_available',
    ];

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
        'is_new' => 'boolean',
        'is_top' => 'boolean',
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

    public function toArray()
    {
        $array = parent::toArray();

        $camelCaseArray = [];
        foreach ($array as $key => $value) {
            $camelCaseKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            $camelCaseArray[$camelCaseKey] = $value;
        }

        return $camelCaseArray;
    }
}
