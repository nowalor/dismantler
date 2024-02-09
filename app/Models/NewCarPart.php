<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'originally_created_at',
        'subgroup',
        'gearbox_nr',
        'brand_name',
        'is_live_on_ebay',
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
            get: static function ($value) {
                $gearbox = str_replace(['5VXL', '6VXL'], '', $value);
                $gearbox = str_replace('AUT', 'Automat', $gearbox);
                $gearbox = str_replace('aut', 'Automat', $gearbox);
                $gearbox = str_replace(',', '.', $gearbox);

                return "$gearbox";
            }
        );
    }

    public function getMyKbaAttribute()
    {
        $engineCode = $this->engine_code;
        $escapedEngineCode = str_replace([' ', '-'], '', $engineCode);

        $this->load(['sbrCode.ditoNumbers.germanDismantlers' => function ($query) use ($engineCode, $escapedEngineCode) {
            $query->whereHas('engineTypes', function ($query) use ($engineCode, $escapedEngineCode) {
                $query->where('name', 'like', "%$engineCode%")
                    ->orWhere('escaped_name', 'like', "%$engineCode%")
                    ->orWhere('name', 'like', "%$escapedEngineCode%")
                    ->orWhere('escaped_name', 'like', "%$escapedEngineCode%");
            });
        }]);

        return $this->sbrCode?->ditoNumbers?->pluck('germanDismantlers')->unique()->flatten() ?? collect([]);
    }

    public function getFullEngineCodeAttribute()
    {
        if ($this->my_kba->count() === 0) {
            return $this->engine_code;
        }

        return round($this->my_kba->first()->engine_capacity_in_cm / 1000, 1) . ' ' . $this->engine_code;
    }

    public function getNewPriceAttribute()
    {
        $priceSek = $this->price_sek;

        if (!$priceSek) {
            return $priceSek;
        }
        /*
         * Calc divider
         */
        if ($priceSek <= 3000) {
            $divider = 7;
        } else if ($priceSek <= 10000) {
            $divider = 8;
        } else {
            $divider = 9;
        }

        return round(((($priceSek / $divider)) * 1.19));
    }

    public function getShipmentAttribute(): int
    {
        $partType = $this->carPartType->germanCarPartTypes->first()->name;
        $dismantleCompanyName = $this->dismantle_company_name;

        $shipment = null;

        // Motor
        if (in_array(
            $partType,
            GermanCarPartType::TYPES_IN_DELIVERY_OPTION_ONE,
            1,
        )) {
            $shipment = 200;

        }

        // Verteilergetriebes, Automatikgetriebe, Schaltgetriebe
        if (in_array(
            $partType,
            GermanCarPartType::TYPES_IN_DELIVERY_OPTION_TWO,
            1,
        )) {
            $shipment = 100;

        }

        // Partikelfilter, Katalysator, Differential
        if (in_array(
            $partType,
            GermanCarPartType::TYPES_IN_DELIVERY_OPTION_THREE,
            1,
        )) {
            $shipment = 70;
        }

        if (in_array(
            $partType,
            GermanCarPartType::TYPES_IN_DELIVERY_OPTION_FOUR,
            1,
        )) {
            $shipment = 50;
        }

        /*
         * Longer delivery
         */
        if ($dismantleCompanyName === 'F' || $dismantleCompanyName === 'A' || $dismantleCompanyName === 'AL') {
            if (in_array(
                $partType,
                GermanCarPartType::TYPES_IN_DELIVERY_OPTION_ONE,
                1,
            )) {
                $shipment += 150;
            } else if (in_array(
                $partType,
                GermanCarPartType::TYPES_IN_DELIVERY_OPTION_FOUR,
                1,
            )) {
                $shipment += 50;
            }
            else {
                $shipment += 100;
            }
        }

        return $shipment * 1.19;
    }

    public function getBusinessPriceAttribute()
    {
        $b2cPrice = $this->new_price;

        $b2bPrice = $b2cPrice * 0.95;

        return round($b2bPrice);
    }

    public function getUniqueKbaAttribute()
    {
        $this->load('sbrCode.ditoNumbers.germanDismantlers.engineTypes');

        return $this->sbrCode->ditoNumbers->pluck('germanDismantlers')->unique()->flatten();

    }

    /*
     * Experimental direct relation between a car part and KBA
     */
    public function germanDismantlers(): BelongsToMany
    {
        return $this->belongsToMany(GermanDismantler::class);
    }

    public function scopeWithKba($query)
    {
        return $query->with(['sbrCode.ditoNumbers.germanDismantlers' => function ($query) {
            $engineCode = $this->engine_code;
            $escapedEngineCode = str_replace([' ', '-'], '', $engineCode);

            $query->whereHas('engineTypes', function ($query) use ($engineCode, $escapedEngineCode) {
                $query->where('name', 'like', "%$engineCode%")
                    ->orWhere('escaped_name', 'like', "%$engineCode%")
                    ->orWhere('name', 'like', "%$escapedEngineCode%")
                    ->orWhere('escaped_name', 'like', "%$escapedEngineCode%");
            });
        }]);
    }
}
