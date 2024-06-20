<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Banner extends Model {
  use HasFactory;
  use Filterable;
  use AsSource;

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

  protected $allowedFilters = [
    'promotion'         => Like::class,
    'updated_at'        => Like::class,
  ];
}
