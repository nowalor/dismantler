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

    public function handle(): int
    {
        $parts = $this->parts();

        if ($parts->isEmpty()) {
            $this->info('empty xml');
            return Command::FAILURE;
        }

        try {
            $response = $this->service->handlePartUpload($parts);

            if (!$response) {
                $this->info('Response failed');
            }
        } catch (\Exception $ex) {
            logger($ex->getMessage());
            $this->info('in catch...');

            return Command::FAILURE;
        }

        $this->info('Everything went okay...');
        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        $optimalParts = new Collection();

        $originalNumbers = NewCarPart::whereIn('car_part_type_id', [1])
//        whereIn('car_part_type_id', [1,2,3,4,5,6,7])
            ->where('is_live_on_ebay', false)
            ->where('engine_code', '!=', '')
            ->whereNotNull('engine_code')
            ->where('model_year', '>', 2007)
            ->whereNull('sold_at')
            ->whereNotNull('article_nr')
            ->whereNotNull('original_number')
            ->whereNotNull('price_eur')
            ->where(function ($q) {
                $q->where('fuel', 'Diesel')
                    ->orWhere('fuel', 'Bensin');
            })
            ->whereHas('carPartImages', function ($q) {
                $q->whereNotNull('image_name_blank_logo');
            })
            ->whereHas('germanDismantlers.kTypes')
            ->with('germanDismantlers.kTypes')
            ->where(function ($query) {
                $query->where('dismantle_company_name', '!=', 'F')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('dismantle_company_name', 'F')
                            ->whereIn('car_part_type_id', [6, 7]);
                    });
            })
            ->take(500)
            //->distinct('original_number')
            ->get();

        return $optimalParts;

        foreach ($originalNumbers as $originalNumber) {
            $parts = (new GetOptimalPartsAction())->execute(
                $originalNumber->original_number,
                $originalNumbers->pluck('id')->toArray()
            );

            $optimalParts = $optimalParts->merge($parts);
        }

        return $optimalParts;
    }
}
