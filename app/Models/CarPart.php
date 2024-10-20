<?php

namespace App\Models;

use App\Scopes\CarPartScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarPart extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected static function booted()
    {
        static::addGlobalScope(new CarPartScope());
    }

    public const CAR_PART_TYPE_IDS_TO_INCLUDE = [
        3574, 3744, 3746, 3749, 3616, 3617, 3812,
        // New ones I am experimenting with
        3969,
        3971,
        4233,
        3157,
        3137,
    ];

    protected $fillable =
        [
            'id',
            'name',
            'comments',
            'notes',
            'quantity',
            'price1',
            'price2',
            'price3',
            'condition',
            'oem_number',
            'shelf_number',
            'year',
            'car_part_type_id',
            'dismantle_company_id',
            'kilo_watt',
            'transmission_type',
            'item_number',
            'car_item_number',
            'item_code',
            'car_vin_code',
            'engine_code',
            'engine_type',
            'kilo_range',
            'alternative_numbers',
            'color',
            'car_first_registration_date',
        ];

    public $incrementing = false;

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

    public function engineType(): BelongsTo
    {
        return $this->belongsTo(EngineType::class);
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

    public function ditoNumber(): BelongsTo
    {
        return $this->belongsTo(DitoNumber::class);
    }
    public function nameForSearch(): Attribute
    {
        return Attribute::make(
            get: fn() => strtolower(str_replace(' ', '', $this->getAttribute('name'))) ,
        );
    }

    public function getDitoNumberFromItemCodeAttribute()
    {
        return substr($this->item_code, 0, 4);
    }
}
