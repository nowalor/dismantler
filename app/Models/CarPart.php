<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarPart extends Model
{
    use HasFactory;

    public function carPartImages(): HasMany
    {
        return $this->hasMany(CarPartImage::class);
    }

    public function carPartType(): BelongsTo
    {
        return $this->belongsTo(CarPartType::class);
    }

    public function dismantleCompany(): BelongsTo
    {
        return $this->belongsTo(DismantleCompany::class);
    }

    public function identifer(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->dismantle_company_id . '_' . $this->item_number,
        );
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->price1 ? $this->price1 : 'Ask for price',
        );
    }

    public function km(): Attribute
    {
        return Attribute::make(
          get: fn() => $this->kilo_watt === '999' ? 'Unknown' : $this->kilo_watt * 1000 . ' km'
        );
    }
}
