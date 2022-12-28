<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CarBrand extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function ditoNumbers(): HasMany
    {
        return $this->hasMany(DitoNumber::class);
    }

    public function carParts(): HasManyThrough
    {
        return $this->hasManyThrough(CarPart::class, DitoNumber::class);
    }
}
