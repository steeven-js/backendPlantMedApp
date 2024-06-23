<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Promotion extends Model
{
    use HasFactory;
    use AsSource;
    use HasFactory;
    use Filterable;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
    ];

    protected $allowedSorts = [
        'name',
        'updated_at',
    ];

    protected $allowedFilters = [
        'name'       => Like::class,
        'updated_at' => Like::class,
    ];
}
