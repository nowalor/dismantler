<?php

namespace App\Console\Commands\Fenix;

use App\Console\Commands\Base\FenixApiBaseCommand;
use App\Models\SwedishCarPartType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FenixApiFetchPartsCommand extends FenixApiBaseCommand
{
    protected $signature = 'fenix:fetch';

    protected $description = 'Command description';

    public function handle(): int
    {
        // Configuration
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);

        $this->authenticate();

        $sbrPartTypeCodes = SwedishCarPartType::select('code')
            ->get()
            ->pluck('code')
            ->toArray();

        foreach($sbrPartTypeCodes as $sbrPartTypeCode) {
            $data = $this->getParts($sbrPartTypeCode);

            $partsFormattedForInsert = $this->formatPartsForInsert($data['Parts']);

            $this->uploadParts($partsFormattedForInsert);

            // TODO handle pagination
        }

        return Command::SUCCESS;
    }

    private function formatPartsForInsert(array $parts): array
    {
        $formattedParts = [];

        foreach($parts as $part) {
            $formattedParts = $this->formatPart($part);
        }
    }

    private function formatPart(array $part): array
    {
        $newPart = [
            'original_id'=> $part['Id'],

        ];

        return $newPart;
    }

    private function uploadParts()
    {

    }
}
