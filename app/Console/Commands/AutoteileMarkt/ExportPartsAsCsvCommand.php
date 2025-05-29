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
        $parts = NewCarPart::with([
            'carPartType.germanCarPartTypes',
            'sbrCode.ditoNumbers.germanDismantlers.engineTypes',
            'ditoNumber',
            'carPartImages',
            'sbrCode',
        ])
            ->whereNotNull('engine_code')
            ->whereHas('sbrCode')
            ->where('quality', '!=', 'M')
            ->whereNotNull('new_name')
            ->whereNotNull('article_nr')
            ->whereHas("carPartImages", function ($query) {
                $query->whereNotNull('new_logo_german');
            })
            ->where('engine_code', '!=', '')
            ->whereNull('sold_at')
            ->whereNotNull('car_part_type_id')
            ->whereIn('car_part_type_id', [1,2,3,4,5,6,7,8 ,9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])
           ->whereNull('fields_resolved_at')
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
