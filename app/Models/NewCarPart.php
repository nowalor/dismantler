<?php

namespace App\Models;

use App\Actions\ConvertCurrencyAction;
use App\Actions\GetLocalizedPriceAction;
use App\Models\Scopes\NewCarPartScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;


class NewCarPart extends Model
{
    use HasFactory;

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new NewCarPartScope());
    }

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

    // Tempararily removed this since we also have a "dito_number" field I wanted to query
    // Will rename the field and comment back in relation if we actually need it...
   /* public function ditoNumber(): BelongsTo
    {
        return $this->belongsTo(DitoNumber::class);
    }*/

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

    public function pageTitle(): string
    {
        $carName = $this->sbr_car_name ?? '';

        // TODO, handle car names for danish parts
        $partType = __('car-part-types.' . $this->carPartType->translation_key) ?? '';

        return "$carName $partType $this->original_number $this->engine_type";
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

        $price = $this->country === 'dk' ? $this->price_dkk : $this->price_sek; // $this->country = country the part is from

        $partTypeKey = $this->carPartType->json_key;

        $priceInfo = (new GetLocalizedPriceAction())->execute(
            $locale,
            $this->country === 'dk' ? 'dk' : 'se',
            $price,
            $partTypeKey,
            $this->dismantle_company_name,
        );

        $convertedPrice = (new ConvertCurrencyAction())->execute(
            $priceInfo['price'], // Price with multiplier,
            $priceInfo['currency']['from'],
            $priceInfo['currency']['to']
        );

        return [
            'requires_request' => $priceInfo['requires_request'],
            'price' => round($convertedPrice),
            'currency' => $priceInfo['currency']['to'],
            'symbol' => $priceInfo['symbol'],
            'shipment' => $priceInfo['shipment'],
            'vat' => $priceInfo['vat'],
        ];
    }

    public function getFullPriceAttribute(): int | string
    {
        $price = $this->getLocalizedPrice();

        if(isset($price['requires_request']) && $price['requires_request']) {
            return 'Please contact us for the price'; // TODO, translation coming from translation file..
        }

        return ($price['price'] + $price['shipment']['total']) * $price['vat'];
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
