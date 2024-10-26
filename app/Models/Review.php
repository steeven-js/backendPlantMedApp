<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Str;

class Review extends Model
{
    use HasFactory;

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

    public function toArray()
    {
        $array = parent::toArray();

        $camelCasedArray = [];
        foreach ($array as $key => $value) {
            $camelCasedArray[Str::camel($key)] = $value;
        }

        return $camelCasedArray;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M, Y');
    }
}
