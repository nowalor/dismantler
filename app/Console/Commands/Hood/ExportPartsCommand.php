<?php

namespace App\Console\Commands\Hood;

use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use App\Actions\Hood\CreateXmlAction as HoodCreateXmlAction;

class ExportPartsCommand extends Command
{
    protected $signature = 'hood:export';


    public function handle(): int
    {
        $parts = $this->parts();

        (new HoodCreateXmlAction())->execute('itemValidate', $parts);

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        return NewCarPart::with("carPartImages")
//            ->where("sbr_car_name", "like", "%audi%") // no audis matching query at the moment??
//            ->where('car_part_type_id', 1) // Currently only getting engines, gearboxes,
            ->where('car_part_type_id', 1) // manual 6 gear gearbox
            // Very important conditions so we don't upload products with data issues
            ->where('is_live_on_hood', false)
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
            ->take(25)
            ->get();
    }
}
