<?php

namespace App\Console\Commands\AutoteileMarkt;

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
        $parts = NewCarPart::with('carPartImages')->whereNotNull('price_sek')
            ->where('price_sek', '>', 0)
            ->whereNotNull('engine_code')
            ->where('engine_code', '!=', '')
            // ->where('dismantle_company_name', 'F')
//            ->whereHas('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
//            ->with('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
            ->whereNull('sold_at')
            ->get();

        foreach ($parts as $index => $part) {
//            if($part->my_kba->count() === 0) {
//                $parts->forget($index);
//                continue;
//            }

            $this->csvService->generateExportCSV($part);

            $part->is_live = true;
            $part->save();
        }

        return Command::SUCCESS;
    }
}
