<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slide extends Model implements HasMedia
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
        'title_line_1',
        'title_line_2',
    ];

    protected $allowedSorts = [
        'updated_at',
        'title_line_1',
        'title_line_2',
        'promotion'
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
