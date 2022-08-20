<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarPartType extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'code'];

    public function carPart(): HasMany
    {
        return $this->hasMany(CarPart::class);
    }
}
