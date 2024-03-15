<?php

namespace App\Console\Commands\Ebay;

use App\Models\NewCarPart;
use App\Services\EbayApiService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CreateXmlCommand extends Command
{
    protected $signature = 'ebay:upload';

    private EbayApiService $service;

    public function __construct()
    {
        $this->service = new EbayApiService();

        parent::__construct();
    }

    public function handle(): string
    {
        $parts = $this->parts();

        if (count($parts) === 0) {
            return 0;
        }

        $this->service->handlePartUpload($parts);

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {

        // Example query we can make to try to get a higher quality of parts
//        NewCarPart::where('car_part_type_id', 1)->where('model_year', '>', 2000)->whereHas('carPartImages')->whereHas('germanDismantlers')->count();

        $parts = NewCarPart::with("carPartImages")
//            ->where("sbr_car_name", "like", "%audi%") // no audis matching query at the moment??
            ->where('car_part_type_id', 3) // Currently only getting engines, gearboxes
            // Very important conditions so we don't upload products with data issues
            ->where('is_live_on_ebay', false)
            ->where('engine_code', '!=', '')
            ->whereNotNull('engine_code')
            ->where('model_year', '>', 2009)
            ->whereNull('sold_at')
            ->whereNotNull('article_nr')
            ->whereNotNull('price_sek')
            ->whereNot('brand_name', 'like', '%mer%')
            ->whereNot('brand_name', 'like', '%bmw%')
            ->where(function ($q) {
                $q->where('fuel', 'Diesel');
                $q->orWhere('fuel', 'Bensin');
            })
            ->whereHas("carPartImages", function ($q) {
                $q->whereNotNull("image_name_blank_logo");
            })
            ->whereHas("germanDismantlers.kTypes")
            ->with("germanDismantlers", function ($q) {
                $q->whereHas("kTypes")->with("kTypes");
            })
            ->where(function ($query) {
                $query
                    ->where('dismantle_company_name', '!=', 'F')
                    ->orWhere(function ($subQuery) {
                        $subQuery
                            ->where('dismantle_company_name', 'F')
                            ->whereIn('car_part_type_id', [6, 7]);
                    });
            })
            ->take(400)
            ->get();

        return $parts;
    }
}
