<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class AppUser extends Model {
  use HasFactory;
  use AsSource;
  use Notifiable;
  use Filterable;

  protected $hidden = [
    'created_at',
    'updated_at',
    'email_otp',
    'phone_otp',
    'password',
    'phone_otp_expires_at',
    'email_otp_expires_at',
  ];

  protected $fillable = [
    'name',
    'email',
    'password'
  ];

  protected $allowedSorts = [
    'name',
    'email',
    'location',
    'created_at',
    'phone_number',
  ];

  protected $allowedFilters = [
    'name'       => Like::class,
    'email'      => Like::class,
    'location'   => Like::class,
    'phone_number' => Like::class,
    'created_at' => Like::class,
  ];

  protected $casts = [
    'email_verified' => 'boolean',
    'phone_verified' => 'boolean'
  ];

  public function toArray() {
    $array = parent::toArray();

    $camelCasedArray = [];
    foreach ($array as $key => $value) {
      $camelCasedArray[Str::camel($key)] = $value;
    }

    return $camelCasedArray;
  }
}
