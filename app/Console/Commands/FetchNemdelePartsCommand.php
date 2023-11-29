<?php

namespace App\Console\Commands;

use App\Enums\DataProviderEnum;
use App\Models\DitoNumber;
use Illuminate\Console\Command;

class FetchNemdelePartsCommand extends Command
{
    protected $signature = 'nemdele:fetch';

    public function handle(): int
    {
        $fileContents = file_get_contents(base_path('app/Mocking/orbak.json'));

        // Decode the JSON data
        $data = json_decode($fileContents, true, 512, JSON_THROW_ON_ERROR);

        foreach ($data as $part) {
            $formattedPart = $this->formatPart($part);
        }

        return Command::SUCCESS;
    }

    private function formatPart(array $part): array
    {
        return [
            'data_provider_id' => DataProviderEnum::Nemdele->value,
            'original_number' => $part['OEMNumber1'],
            'dito_number_id' => $this->getDitonumberId($part),
            'original_id' => $part['StockID'],
            'price_dkk' => $part['Price'],
            'brand' => $part['ManufacturerName'],
            'vin' => $part['StelNr'],

            'model' => $part['Model'], // TODO Need to add to DB??
            'car_part_type_id' => '???' // TODO
        ];
    }

    private function getDitonumberId(array $part): int | null
    {
        if(!isset($part['CarType'])) {
            return null;
        }

        $ditoNumber = DitoNumber::where('dito_number', $part['CarType'])->first();

        if(!$ditoNumber) {
            return null;
        }

        return $ditoNumber->id;
    }
}
