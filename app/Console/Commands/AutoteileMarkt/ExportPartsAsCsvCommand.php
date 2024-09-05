<?php

namespace App\Console\Commands\AutoteileMarkt;

use App\Models\CarPart;
use App\Models\NewCarPart;
use App\Services\AutoteileMarkDocService;
use Illuminate\Console\Command;

class ExportPartsAsCsvCommand extends Command
{
    protected $signature = 'autoteile-markt:export';

    private AutoteileMarkDocService $csvService;

    public function __construct()
    {
        $this->csvService = new AutoteileMarkDocService();

        parent::__construct();
    }

    public function handle(): int
    {
        $parts = NewCarPart::
            whereNotNull('engine_code')
            ->where('quality', '!=', 'M')
            ->whereNotNull('new_name')
            ->whereNotNull('article_nr')
            ->whereHas("carPartImages", function ($query) {
                $query->whereNotNull('new_logo_german');
            })
            ->where('engine_code', '!=', '')
            ->whereNull('sold_at')
            ->whereNotNull('car_part_type_id')
            ->where('is_live', false)
            ->where(function ($query) {
                $query
                    ->where('dismantle_company_name', '!=', 'F')
                    ->orWhere(function ($subQuery) {
                        $subQuery
                            ->where('dismantle_company_name', 'F')
                            ->whereIn('car_part_type_id', [6, 7]);
                    });
            })
            ->take(5000)
            ->get();

//        $parts = NewCarPart::where('article_nr', 'BO611843')->get();

        foreach ($parts as $index => $part) {
//            if($part->my_kba->count() === 0) {
//                $parts->forget($index);
//                continue;
//            }

            if($part->quality == 'M') {
                continue;
            }

            $this->csvService->generateExportCSV($part);

            $part->is_live = true;
            $part->save();
        }

        return Command::SUCCESS;
    }
}
