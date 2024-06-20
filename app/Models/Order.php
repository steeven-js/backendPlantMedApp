<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Order extends Model {
  use AsSource;
  use HasFactory;
  use Filterable;

  protected $hidden = [
    'updated_at',
  ];

  protected $fillable = [
    'name',
    'total',
    'email',
    'status',
    'user_id',
    'address',
    'delivery',
    'discount',
    'products',
    'subtotal',
    'phone_number',
    'order_status',
    'card_holder_name',
  ];

  protected $allowedSorts = [
    'name',
    'total',
    'created_at',
    'phone_number',
    'order_status',
  ];

  protected $allowedFilters = [
    'name'       => Like::class,
    'created_at' => Like::class,
    'phone_number' => Like::class,
    'order_status' => Like::class,
    'total' => Like::class,
  ];

  protected $casts = [
    'products' => 'array',
  ];

  public function toArray() {
    $array = parent::toArray();

    // Рекурсивная функция для преобразования ключей массива в camelCase
    $arrayCamelCase = function ($array) use (&$arrayCamelCase) {
      $result = [];
      foreach ($array as $key => $value) {
        if (is_array($value)) {
          $value = $arrayCamelCase($value);
        }
        $result[lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))))] = $value;
      }
      return $result;
    };

    return $arrayCamelCase($array);
  }

  public function getCreatedAtAttribute($value) {
    return Carbon::parse($value)->format('d M, Y');
  }
}
