<?php

namespace App\Models;

use App\Scopes\CarPartTypeScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarPartType extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new CarPartTypeScope());
    }

    protected $fillable = ['id', 'name', 'code'];

    public function carPart(): HasMany
    {
        return $this->hasMany(CarPart::class);
    }
}
