<?php

namespace App\Models;

use App\Models\Scopes\CarPartImageScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarPartImage extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new CarPartImageScope());
    }

    protected $fillable = [
      'car_part_id',
      'origin_url',
      'thumbnail_url',
    ];

    public function CarPart(): BelongsTo
    {
        return $this->belongsTo(CarPart::class);
    }
}
