<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewCarPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_nr',
        'original_id',
        'car_part_type_id',
        'internal_dismantle_company_id',
        'external_dismantle_company_id',
        'data_provider_id',
        'name',
        'price',
        'quantity',
        'sbr_part_code',
        'sbr_car_code',
        'original_number',
        'quality',
        'engine_code',
        'engine_type',
        'dismantled_at',
        'dismantle_company_name',
        'article_nr_at_dismantler',
        'sbr_car_name',
        'body_name',
        'fuel',
        'gearbox',
        'warranty',
        'mileage_km',
        'model_year',
        'vin'
    ];

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

    public function carPartImages(): HasMany
    {
        return $this->hasMany(NewCarPartImage::class);
    }

    public function sbrCode(): BelongsTo
    {
        return $this->belongsTo(SbrCode::class);
    }
}
