<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Plant extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $hidden = [
        'created_at',
        'updated_at',
        'is_active',
        'is_available',
    ];

    protected $fillable = [
        'name',
        'image',
        'price',
        'color',
        'colors',
        'images',
        'is_new',
        'is_top',
        'quantity',
        'old_price',
        'is_active',
        'pot_types',
        'promotion',
        'categories',
        'description',
        'is_featured',
        'plant_types',
        'is_best_seller',
        'is_available'
    ];

    protected $casts = [
        'images' => 'array',
        'colors' => 'array',
        'is_new' => 'boolean',
        'is_top' => 'boolean',
        'pot_types' => 'array',
        'categories' => 'array',
        'plant_types' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_available' => 'boolean',
        'is_best_seller' => 'boolean',
    ];

    protected $allowedSorts = [
        'name',
        'price',
        'rating',
        'quantity',
        'is_active',
        'old_price',
        'updated_at',
        'description',
    ];

    protected $allowedFilters = [
        'name'           => Like::class,
        'price'          => Like::class,
        'quantity'       => Like::class,
        'old_price'      => Like::class,
        'description'    => Like::class,
    ];

    public function toArray()
    {
        $array = parent::toArray();

        // Преобразование имен атрибутов из "snake_case" в "camelCase"
        $camelCaseArray = [];
        foreach ($array as $key => $value) {
            $camelCaseKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            $camelCaseArray[$camelCaseKey] = $value;
        }

        dd($camelCaseArray);

        return $camelCaseArray;
    }
}
