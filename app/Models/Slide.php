<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Slide extends Model implements HasMedia
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use InteractsWithMedia;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'image',
        'promotion',
        'title_line_1',
        'title_line_2',
    ];

    protected $allowedSorts = [
        'updated_at',
        'title_line_1',
        'title_line_2',
        'promotion'
    ];

    protected $allowedFilters = [
        'updated_at'          => Like::class,
        'title_line_1'        => Like::class,
        'title_line_2'        => Like::class,
        'promotion'           => Like::class,
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
