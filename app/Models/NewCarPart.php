<?php

namespace App\Models;

use App\Actions\ConvertCurrencyAction;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\App;


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
        'new_name',
        'description_name',
        'is_live_on_hood',
        'external_part_type_id',
        'country',
        'dito_number',
        'danish_item_code',
        'mileage',
    ];

    public function carPartType(): BelongsTo {
        return $this->belongsTo(CarPartType::class);
    }

    public function dismantleCompany(): BelongsTo {
        return $this->belongsTo(DismantleCompany::class);
    }

    public function engineType(): BelongsTo {
        return $this->belongsTo(EngineType::class);
    }

    public function carPartImages(): HasMany {
        return $this->hasMany(NewCarPartImage::class);
    }

    public function sbrCode(): BelongsTo {
        return $this->belongsTo(SbrCode::class);
    }

    public function gearbox(): Attribute {
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

    // New method to get raw gearbox value
    public function getRawGearboxAttribute(): string {
        return $this->attributes['gearbox'];
    }
    public function ditoNumber(): BelongsTo
    {
        return $this->belongsTo(DitoNumber::class);
    }

    public function getMyKbaThroughDitoAttribute()
    {
        $engineCode = $this->engine_code;
        $escapedEngineCode = str_replace([' ', '-'], '', $engineCode);

        $this->load(['ditoNumber.germanDismantlers' => function ($query) use ($engineCode, $escapedEngineCode) {
            $query->whereHas('engineTypes', function ($query) use ($engineCode, $escapedEngineCode) {
                $query->where('name', 'like', "%$engineCode%")
                    ->orWhere('escaped_name', 'like', "%$engineCode%")
                    ->orWhere('name', 'like', "%$escapedEngineCode%")
                    ->orWhere('escaped_name', 'like', "%$escapedEngineCode%");
            });
        }]);

        return $this->sbrCode?->ditoNumbers?->pluck('germanDismantlers')->unique()->flatten() ?? collect([]);

    }

    public function getMyKbaAttribute() {
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

    public function getFullEngineCodeAttribute() {
        if ($this->my_kba->count() === 0) {
            return $this->engine_code;
        }

        return round($this->my_kba->first()->engine_capacity_in_cm / 1000, 1) . ' ' . $this->engine_code;
    }

    public function getTranslatedPriceAttribute()
    {
      $priceDkk = $this->price_dkk;

      return $priceDkk / 4;
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

    // price in EUR
    public function getAutoteileMarktPriceAttribute() {
        $priceSek = $this->price_sek;

        if (!$priceSek) {
            return $priceSek;
        }

        if ($priceSek <= 2000) {
            $divider = 7;
        } else if($priceSek <= 3000) {
            $divider = 8;
        } else if ($priceSek <= 10000) {
            $divider = 9;
        } else if ($priceSek <= 20000) {
            $divider = 10;
        } else {
            $divider = 11;
        }

        return round(((($priceSek / $divider)) * 1.19));
    }

    public function getEbayPriceAttribute(): float
    {
        return 1.1 * $this->getAutoteileMarktPriceAttribute();
    }

    // price in EUR
    public function getAutoteileMarktPriceWithShipping() {

        $priceEuro = $this->getAutoteileMarktBusinessPriceAttribute();

        if (!$priceEuro) {
            return null;
        }

        $shipmentCost = $this->shipment;

        if ($shipmentCost) {
            $priceEuro += $shipmentCost;
        }

        return round($priceEuro, 2);
    }

    // Calculate shipment cost
    public function getShipmentAttribute(): int | null {

      $partType = $this->carPartType?->germanCarPartTypes?->first()?->name;

      if (!$partType) {
          return null;
      }

        $dismantleCompanyName = $this->dismantle_company_name;
        $shipment = match(true) {
            in_array($partType, GermanCarPartType::TYPES_IN_DELIVERY_OPTION_ONE, true) => 200,
            in_array($partType, GermanCarPartType::TYPES_IN_DELIVERY_OPTION_TWO, true) => 150,
            in_array($partType, GermanCarPartType::TYPES_IN_DELIVERY_OPTION_THREE, true) => 100,
            in_array($partType, GermanCarPartType::TYPES_IN_DELIVERY_OPTION_FOUR, true) => 50,
            default => 50,
        };

        // Add additional cost for certain dismantle companies
        if (in_array($dismantleCompanyName, ['F', 'A', 'AL', 'D', 'LI', 'W'])) {
            $additionalShipment = match(true) {
                in_array($partType, GermanCarPartType::TYPES_IN_DELIVERY_OPTION_ONE, true) => 150,
                in_array($partType, GermanCarPartType::TYPES_IN_DELIVERY_OPTION_FOUR, true) => 100,
                default => 100,
            };
            $shipment += $additionalShipment;
        }

            return floor($shipment * 1.19);
    }

    public function getShipmentCost(): int | null {
        return $this->getShipmentAttribute();
    }


    // including VAT + Shipping
    public function getTotalPriceEUR() {
        $shipmentPrice = $this->getShipmentAttribute();

        $autoteileMarktPrice = $this->getAutoteileMarktPriceAttribute();

        $finalPrice = $autoteileMarktPrice + $shipmentPrice;

        return $finalPrice;
    }

    public function getLocalizedPrice(): array
    {
        $locale = App::getLocale();

        $price = $this->country === 'dk' ? $this->price_dkk : $this->price_sek;
        $from = $this->country === 'dk' ? 'dkk' : 'sek';
        $to = 'eur';

        if($locale === 'dk') {
            $to = 'dkk';
        }


        if($locale === 'se') {
            $to = 'sek';
        }

        $multiplier = $this->country === 'dk' ? $this->getDanishPartPriceMultiplier()
            : $this->getSwedishPartPriceMultiplier();

        $convertedPrice = (new ConvertCurrencyAction())->execute(
            $price * $multiplier,
            $from,
            $to
        );

        return [
            'currency' => $to,
            'price' => round($convertedPrice),
            'symbol' => $to === 'eur' ? '€' : strtoupper($to),
        ];
    }

    private function getSwedishPartPriceMultiplier() : int
    {
        if($this->price_sek < 2001) {
            return 1.4;
        } elseif ($this->price_sek < 5000) {
            return 1.3;
        }

        return 1.25;
    }

    private function getDanishPartPriceMultiplier()
    {

    }

    public function getLocalizedShipment(): array
    {
        $locale = App::getLocale();

        if($locale === 'dk') {
            $symbol = 'DKK';
            $currency = 'dkk';

            if($this->car_part_type_id === 1) {
                $price = 1500;

                if($this->dismantle_company_name === 'A') {
                    $price = $price + 750;
                }

                return [
                    'price' => $price,
                    'symbol' => $symbol,
                    'currency' => $currency,
                ];
            }

            if($this->car_part_type_id === 2) {
                $price = 1000;

              /*  if($this->dismantle_company_name === 'al') {
                    $price = $price + 750;
                }*/

                return [
                    'price' => $price,
                    'currency' => $symbol,
                ];
            }
        }

        if($locale === 'de') {
            $symbol = '€';
            $currency = 'eur';

            if($this->car_part_type_id === 1) {
                $price = 200;

                if(in_array($this->dismantle_company_name, [
                    'A', // Ådalens Bildemontering AB
                    'F', // Norrbottens Bildemontering AB
                    'D', // Trollhättan
                    'LI', // Lidköping
                    'AL', // Allbildelar,
                    'W' // Lycksele
                ])) {
                    $price = $price + 150;
                }

                return [
                    'price' => $price,
                    'symbol' => $symbol,
                    'currency' => $currency,
                ];
            }

            if($this->car_part_type_id === 2) {
                $price = 150;

                if(in_array($this->dismantle_company_name, [
                    'A', // Ådalens Bildemontering AB
                    'F', // Norrbottens Bildemontering AB
                    'D', // Trollhättan
                    'LI', // Lidköping
                    'AL', // Allbildelar,
                    'W' // Lycksele
                ])) {
                    $price = $price + 100;
                }

                return [
                    'price' => $price,
                    'symbol' => $symbol,
                    'currency' => $currency,
                ];
            }

            if($this->car_part_type_id === 3) {
                $price = 100;

                if(in_array($this->dismantle_company_name, [
                    'A', // Ådalens Bildemontering AB
                    'F', // Norrbottens Bildemontering AB
                    'D', // Trollhättan
                    'LI', // Lidköping
                    'AL', // Allbildelar,
                    'W' // Lycksele
                ])) {
                    $price = $price + 100;
                }

                return [
                    'price' => $price,
                    'symbol' => $symbol,
                    'currency' => $currency,
                ];
            }
        }
    }

    public function getBusinessPriceAttribute() {
        $b2cPrice = $this->new_price;

        $b2bPrice = $b2cPrice * 0.95;

        return round($b2bPrice);
    }

    public function getAutoteileMarktBusinessPriceAttribute() {
        $b2cPrice = $this->autoteile_markt_price;

        $b2bPrice = $b2cPrice * 0.95;

        return round($b2bPrice);
    }

    public function getUniqueKbaAttribute() {
        $this->load('sbrCode.ditoNumbers.germanDismantlers.engineTypes');

        return $this->sbrCode->ditoNumbers->pluck('germanDismantlers')->unique()->flatten();
    }

    /*
     * Experimental direct relation between a car part and KBA
     */
    public function germanDismantlers(): BelongsToMany {
        return $this->belongsToMany(GermanDismantler::class);
    }

    public function scopeWithKba($query) {
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

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
