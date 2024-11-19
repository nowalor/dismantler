<?php

namespace App\Models;

use App\Scopes\CarPartTypeScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarPartType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected static function booted()
    {
//        static::addGlobalScope(new CarPartTypeScope());
    }

    protected $fillable = ['id', 'name', 'code'];

    protected $hidden = ['pivot'];

//    public function carPart(): HasMany
//    {
//        return $this->hasMany(CarPart::class);
//    }

    public function subCategories() 
    {
        return $this->hasMany(SubCategory::class);
    }

    public function germanCarPartTypes(): BelongsToMany
    {
        return $this->belongsToMany(GermanCarPartType::class);
    }

    public function carParts(): HasMany
    {
        return $this->hasMany(NewCarPart::class);
    }

    public function danishCarPartTypes(): BelongsToMany
    {
        return $this->belongsToMany(DanishCarPartType::class);
    }

    public function swedishCarPartTypes(): BelongsToMany
    {
        return $this->belongsToMany(SwedishCarPartType::class);
    }

    public static function getAllCarPartTypes(): Collection
    {
        return self::with(
            'germanCarPartTypes',
            'danishCarPartTypes',
            'swedishCarPartTypes'
        )->get();
    }
}
