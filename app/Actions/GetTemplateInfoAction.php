<?php

namespace App\Actions;

use App\Models\NewCarPart;

class GetTemplateInfoAction
{
    public function execute(NewCarPart $part): array
    {
        $fuel = $part->fuel;

        if ($fuel === 'Bensin') {
            $fuel = 'Benzin';
        }

        $data = [
            [
                'label' => 'Hersteller',
                'value' => $this->getProducer($part),
            ],
            [
                'label' => 'Modell',
                'value' => $this->getBrand($part),
            ],
            [
                'label' => 'Bauahr',
                'value' => $part->model_year,
            ],
            [
                'label' => 'Originale Ersatzteilnummer',
                'value' => $part->original_number,
            ],
            [
                'label' => 'Motortype',
                'value' => $part->engine_type,
            ],
            [
                'label' => 'Treibstoffart',
                'value' => $fuel,
            ],
            [
                'label' => 'Qualität',
                'value' => 'Gebrauchtteil',
            ],
            [
                'label' => 'Laufleistung(km)',
                'value' => $part->mileage_km,
            ],
            [
                'label' => 'Getriebe',
                'value' => $part->gearbox_nr,
            ],
            [
                'label' => 'Fahrgestellnummer',
                'value' => $part->vin,
            ],
            [
                'label' => 'Lagernummer',
                'value' => $part->article_nr,
            ],
            [
                'label' => 'Kba',
                'value' => $this->getKba($part),
            ],
        ];

        return $data;
    }

    private function getProducer(NewCarPart $carPart): string
    {
        $dito = $carPart->sbrCode?->ditoNumbers()->first();

        if(!$dito) {
            return $carPart->sbr_car_name;
        }

        return $dito->producer;
    }

    private function getBrand(NewCarPart $carPart): string
    {
        $dito = $carPart->sbrCode?->ditoNumbers()->first();

        if(!$dito) {
            return $carPart->sbr_car_name;
        }

        return $dito->brand;
    }

    private function getKba(NewCarPart $part): string
    {
        $kba = $part->my_kba->map(function ($kbaNumber) {
            return [
                'hsn' => $kbaNumber->hsn,
                'tsn' => $kbaNumber->tsn,
            ];
        })->toArray();

        $propertiesArray = array_map(function ($kbaNumber) {
            return $kbaNumber['hsn'] . $kbaNumber['tsn'];
        }, $kba);

        return implode(',', $propertiesArray);
    }
}
