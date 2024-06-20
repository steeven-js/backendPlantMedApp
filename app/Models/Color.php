<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;

class Color extends Model {
  use HasFactory;
  use AsSource;
  use Filterable;

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $fillable = [
    'name',
    'code',
  ];

  protected $allowedSorts = [
    'name',
    'code',
    'updated_at',
  ];

  protected $allowedFilters = [
    'name'       => Like::class,
    'code'       => Like::class,
    'updated_at' => Like::class,
  ];
}
