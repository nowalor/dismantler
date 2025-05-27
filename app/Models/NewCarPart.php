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
use Illuminate\Support\Collection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Builder;


class NewCarPart extends Model
{
    use HasFactory;

    protected static function booted()
    {
        parent::booted();

      /* static::addGlobalScope(new NewCarPartScope());*/
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
        'dito_number_part_code',
        'danish_item_code',
        'mileage',
        'fields_resolved_at',
    ];

    public function findRelevantParts(): Collection|null
    {
        if (!$this->isValidForBestMatch())
        {
            return null;
        }

        $parts = new Collection();

        $cheapestPart = $this->baseRelevantPartsQuery()
            ->where('price_sek', '<', $this->price_sek)
            ->orderBy('price_sek')
            ->where('mileage_km', 'REGEXP', '^[0-9]+$')
            ->orderByRaw('CAST(mileage_km AS UNSIGNED)')
            ->first();

        $partWithBestMileage = $this->baseRelevantPartsQuery()
            ->where('mileage_km', 'REGEXP', '^[0-9]+$')
            ->whereRaw('CAST(mileage_km AS UNSIGNED) < CAST(? AS UNSIGNED)', [$this->mileage_km])
            ->orderByRaw('CAST(mileage_km AS UNSIGNED)')
            ->orderBy('price_sek')
            ->first();

        if ($cheapestPart) {
            $cheapestPart->label = __('cheapest-similar-part');
            $parts->push($cheapestPart);
        }

        if ($partWithBestMileage && (!$cheapestPart || $partWithBestMileage->id !== $cheapestPart->id))
        {
            $partWithBestMileage->label = __('best-mileage-similar-part');
            $parts->push($partWithBestMileage);
        }

        return $parts;
    }

        private function baseRelevantPartsQuery(): Builder
    {
        return self::where('id', '!=', $this->id)
            ->where('original_number', $this->original_number)
            ->where('car_part_type_id', $this->car_part_type_id)
            ->where('mileage_km', '!=', 0);
    }

    private function isValidForBestMatch(): bool
    {
        return self::whereNotNull('original_number')
            ->where('original_number', '!=', '')
            ->where('original_number', '!=', '-')
            ->whereNotNull('car_part_type_id')
            ->where('car_part_type_id', '!=', '')
            ->where('id', $this->id)
            ->exists();
    }

    public function prepareCheckoutBreadcrumbs(): array | null
    {
        $carPartBreadcrumbs = $this->prepareCarPartBreadcrumbs();

        $breadcrumbs = [];

        $breadcrumbs[0] = [
            'name' => 'Home',
            'route' => route('landingpage')
        ];

        $breadcrumbs[1] = [
            'name' => 'Car parts',
            'route' => route('car-parts.search-by-name')
        ];

        if ($carPartBreadcrumbs) {
            // brand
            $breadcrumbs[2] = $carPartBreadcrumbs[0];

            // brand + model
            $breadcrumbs[3] = $carPartBreadcrumbs[1];

            // brand + model + car part name
            $breadcrumbs[4] = $carPartBreadcrumbs[2];

            // oem
            $breadcrumbs[5] = $carPartBreadcrumbs[3];
        }

        // brand + model + car part name + original number + mileage
        $breadcrumbs[count($breadcrumbs)] = [
            'name' => $this->new_name,
            'route' => route('fullview', $this),
        ];

        $breadcrumbs[count($breadcrumbs)] = [
            'name' => __('checkout.checkout'),
            'route' => null,
        ];
        
        return $breadcrumbs;
    }
    
    public function prepareCarPartBreadcrumbs(): array | null
    {
        $rawBreadcrumb = $this->prepareBreadcrumbData();

        if (!$rawBreadcrumb) {
            return null;
        }

        $breadcrumbs = [];
        
        // brand
        $breadcrumbs[0] = [
            'name' => $rawBreadcrumb->producer,
            'route' => route('car-parts.search-by-name', [
                'search' => $rawBreadcrumb->producer,])
        ];

        // brand + model
        $breadcrumbs[1] = [
            'name' => $rawBreadcrumb->car_name,
            'route' => route('car-parts.search-by-model', [
                'brand' => $rawBreadcrumb->producer_id,
                'dito_number_id' => $rawBreadcrumb->dito_number_id,])
        ];

        // brand + model + car part name
        $breadcrumbs[2] = [
            'name' => $rawBreadcrumb->car_name . ' ' . $rawBreadcrumb->car_part_type,
            'route' => route('car-parts.search-by-model', [
                'brand' => $rawBreadcrumb->producer_id,
                'dito_number_id' => $rawBreadcrumb->dito_number_id,
                'type_id' => $rawBreadcrumb->car_part_type_id,])
        ];

         // original number
        $breadcrumbs[3] = [
            'name' => $rawBreadcrumb->original_number,
            'route' => route('car-parts.search-by-oem', [
                'oem' => $rawBreadcrumb->original_number,])
        ];

        // brand + model + car part name + original number + mileage
        $breadcrumbs[4] = [
            'name' => $rawBreadcrumb->car_name . ' ' . $rawBreadcrumb->car_part_type . ' ' . $rawBreadcrumb->original_number . ' ' . $rawBreadcrumb->mileage_km . 'KM',
            'route' => null
        ];

        return $breadcrumbs;
    }

    public function prepareBreadcrumbData(): object | null
    {
        $ditoNumbers = $this->sbrCode?->ditoNumbers;
        $firstDitoNumber = $ditoNumbers?->first();

        $rawBreadcrumb = (object) [
            'producer_id' => $firstDitoNumber?->car_brand_id,
            'producer' => $firstDitoNumber?->producer,
            'dito_number_id' => $firstDitoNumber?->id,
            'car_name' => $this->sbr_car_name,
            'car_part_type_id' => $this->car_part_type_id,
            'car_part_type' => __('car-part-types.' . $this->carPartType?->translation_key) ?? '',
            'original_number' => $this->original_number,
            'mileage_km' => $this->mileage_km,
        ];

        foreach ($rawBreadcrumb as $value) {
            if ($value === null) {
                return null;
            }
        }

        return $rawBreadcrumb;
    }

    
    public function getRouteKey(): string
    {
        $route = '';

        $dito = $this->sbrCode?->ditoNumbers()->first();

        if($dito) {
            $route .= "{$dito->route_key}-";
        }

        /*
        * Didn't want to bother with going through translation files for the first version of the SEO URLS
        * but it's probably worth it to do it in the future...
        */
      /*  if($this->car_part_type_id) {
            $route .= "{$this->carPartType->translation_key}-";
        }*/

        if($this->original_number && strlen($this->original_number) > 2) {
            $route .= "$this->original_number-";
        }

        $route .= "$this->id";

        return $route;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $segments = explode('-', $value);
        $id = end($segments);

        return static::findOrFail($id);
    }

    public function carPartType(): BelongsTo
    {
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
        $partType = __('car-part-types.' . $this->carPartType?->translation_key) ?? '';

        return "$carName $partType $this->original_number $this->engine_type";
    }


    // including VAT + Shipping
    public function getTotalPriceEUR() {
        $shipmentPrice = $this->getShipmentAttribute();

        $autoteileMarktPrice = $this->getAutoteileMarktPriceAttribute();

        $finalPrice = $autoteileMarktPrice + $shipmentPrice;

        return $finalPrice;
    }

    public function getLocalizedPrice($browsingCountry = null): array
    {
        if (!$browsingCountry) {
            $browsingCountry = session('browsing_country', 'de');
        }

        if ($browsingCountry === 'da' && $price = $this->price_dkk) {
            $price = $this->price_dkk;
            $priceSource = 'da';
        } else {
            $price = $this->price_sek;
            $priceSource = 'sv';
        }

        // TODO, handle it in another way, like not querying these parts in the first place...
        if(!$this->carPartType || !$price) {
            $priceInfo = (new GetLocalizedPriceAction())->requiresRequest();

            return [
                'requires_request' => $priceInfo['requires_request'],
                'price' => 999999999999999999,
                'currency' => $priceInfo['currency']['to'],
                'symbol' => $priceInfo['symbol'],
                'shipment' => $priceInfo['shipment'],
                'vat' => $priceInfo['vat'],
            ];
        }

        $partTypeKey = $this->carPartType->json_key;

        $priceInfo = (new GetLocalizedPriceAction())->execute(
            $browsingCountry,
            $priceSource,
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

    public function ebayPrice(string $locale): int | null
    {
        $price = $this->getLocalizedPrice($locale);

        if(isset($price['requires_request']) && $price['requires_request']) {
            return null;
        }

        return (($price['price'] + $price['shipment']['total']) * $price['vat']);

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
