<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'vin',
        'price_sek',
        'price_eur',
        'price_dkk',
        'price_nok',
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

    public function gearbox(): Attribute
    {
        return Attribute::make(
            get: static function($value) {
                $gearbox =  str_replace(['5VXL', '6VXL'], '',$value);
                $gearbox =  str_replace('AUT', 'Automat', $gearbox);
                $gearbox =  str_replace('aut', 'Automat', $gearbox);
                $gearbox = str_replace(',', '.', $gearbox);

                return "$gearbox";
            }
        );
    }

    public function getMyKbaAttribute()
    {
        $engineCode = $this->engine_code;

        $this->load(['sbrCode.ditoNumbers.germanDismantlers' => function ($query) use ($engineCode) {
            $query->whereHas('engineTypes', function ($query) use ($engineCode) {
                $query->where('name', 'like', "%$engineCode%");
            });
        }]);

        return $this->sbrCode->ditoNumbers->pluck('germanDismantlers')->unique()->flatten();
    }

    public function getFullEngineCodeAttribute()
    {
        if($this->my_kba->count() === 0) {
            return $this->engine_code;
        }

        return round($this->my_kba->first()->engine_capacity_in_cm / 1000, 1) . ' ' . $this->engine_code;
    }

    public function getUniqueKbaAttribute()
    {
        $this->load('sbrCode.ditoNumbers.germanDismantlers.engineTypes');

        return $this->sbrCode->ditoNumbers->pluck('germanDismantlers')->unique()->flatten();

    }
}
