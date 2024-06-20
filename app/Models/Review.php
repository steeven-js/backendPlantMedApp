<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Review extends Model {
  use AsSource;
  use HasFactory;
  use Filterable;

  protected $hidden = [
    'updated_at',
  ];

  protected $fillable = [
    'comment',
    'rating',
    'name',
    'email',
    'product_id',
  ];

  protected $allowedSorts = [
    'name',
    'email',
    'rating',
    'comment',
    'updated_at',
  ];

  protected $allowedFilters = [
    'name'       => Like::class,
    'email'      => Like::class,
    'updated_at' => Like::class,
    'comment'    => Like::class,
    'rating'     => Like::class,
  ];

  public function toArray() {
    $array = parent::toArray();

    $camelCasedArray = [];
    foreach ($array as $key => $value) {
      $camelCasedArray[Str::camel($key)] = $value;
    }

    return $camelCasedArray;
  }

  public function getCreatedAtAttribute($value) {
    return Carbon::parse($value)->format('d M, Y');
  }
}
