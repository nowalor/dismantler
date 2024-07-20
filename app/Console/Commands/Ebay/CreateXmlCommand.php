<?php

namespace App\Console\Commands\Ebay;

use App\Actions\Parts\GetOptimalPartsAction;
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
        logger($parts); exit;

        if (count($parts) === 0) {
            return 0;
        }

        try {
            $response = $this->service->handlePartUpload($parts);

            if(!$response) {
                $this->info('Response failed');
            }
        } catch(\Exception $ex) {
            logger($ex->getMessage());

            $this->info('in catch...');

            return 1;
        }


        $this->info('Everything went okay...');
        return Command::SUCCESS;
    }

    private function parts(): Collection
    {

        // Example query we can make to try to get a higher quality of parts
//        NewCarPart::where('car_part_type_id', 1)->where('model_year', '>', 2000)->whereHas('carPartImages')->whereHas('germanDismantlers')->count();

        $optimalParts = [];

        $originalNumbers = NewCarPart::select(['id', 'original_number'])
//            with("carPartImages")
            ->whereIn('car_part_type_id', [1,2,3,4,5,6,7])
//            ->where('is_live_on_ebay', false)
            ->where('engine_code', '!=', '')
            ->whereNotNull('engine_code')
            ->where('model_year', '>', 2007)
            ->whereNull('sold_at')
            ->whereNotNull('article_nr')
            ->whereNotNull('original_number')
            ->whereNotNull('price_eur')
//            ->whereNot('brand_name', 'like', '%mer%')
//            ->whereNot('brand_name', 'like', '%bmw%')
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
            ->take(600)
            ->distinct('original_number')
            ->get();

        foreach($originalNumbers as $originalNumber) {
            $parts = (new GetOptimalPartsAction())->execute(
                $originalNumber->original_number,
                $originalNumbers->pluck('id')->toArray(),
            );

            array_push($optimalParts, ...$parts);
        }

        return Collection::make($optimalParts);
    }
}
