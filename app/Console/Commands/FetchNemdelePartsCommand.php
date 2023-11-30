<?php

namespace App\Console\Commands;

use App\Enums\DataProviderEnum;
use App\Models\DanishCarPartType;
use App\Models\DitoNumber;
use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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

            NewCarPart::create($formattedPart);
        }

        return Command::SUCCESS;
    }

    private function formatPart(array $part): array
    {
        return [
            'name' => $part['PartName'],
            'data_provider_id' => DataProviderEnum::Nemdele->value,
            'original_number' => $part['OEMNumber1'],
            'dito_number_id' => $this->getDitonumberId($part),
            'original_id' => $part['StockID'],
            'price_dkk' => $part['Price'],
            'brand' => $part['ManufacturerName'],
            'vin' => $part['StelNr'],
            'model_year' => $part['Year'],
            'originally_created_at' => $this->formatDate($part['Created']),
            'car_part_type_id' => $this->getCarPartTypeId($part), // TODO
            'mileage_km' => $part['Mileage'],


            'model' => $part['Model'], // TODO Need to add to DB??
        ];
    }

    // Take 22-11-2023 13:10:01 and turn into a datetime
    private function formatDate(string $date): Carbon
    {
        $date = str_replace('/', '-', $date);

        return Carbon::createFromFormat('d-m-Y H:i:s', $date);
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

    private function getCarPartTypeId(array $part): int | null
    {
        $ditoPartCode = $part['PartType'];

        if(!$ditoPartCode) {
            return null;
        }

        $danishPartType = DanishCarPartType::where('code', $ditoPartCode)->first();

        if(!$danishPartType) {
            // TODO some kind of alert

            return null;
        }

        return $danishPartType->carPartTypes()->first()->id;
    }
}
