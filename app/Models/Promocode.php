<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Promocode extends Model
{
    use HasFactory;
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'code',
        'discount',
        'expires_at',
    ];

    protected $allowedSorts = [
        'code',
        'discount',
        'updated_at',
        'expires_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y',
        'updated_at' => 'datetime:d.m.Y',
    ];

    public function getExpiresAtAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y');
    }
}
