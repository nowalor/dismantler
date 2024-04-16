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
                'value' => 'TODO',
            ],
            [
                'label' => 'Modell',
                'value' => 'TODO',
            ],
            [
                'label' => 'Bauahr',
                'value' => 'TODO',
            ],
            [
                'label' => 'Originale Ersatzteilnummer',
                'value' => 'TODO',
            ],
            [
                'label' => 'Motortype',
                'value' => 'TODO',
            ],
            [
                'label' => 'Treibstoffart',
                'value' => $fuel,
            ],
            [
                'label' => 'Qualität',
                'value' => 'TODO',
            ],
            [
                'label' => 'Laufleistung(km)',
                'value' => 'TODO',
            ],
            [
                'label' => 'Getriebe',
                'value' => 'TODO',
            ],
            [
                'label' => 'Fahrgestellnummer',
                'value' => 'TODO',
            ],
            [
                'label' => 'Lagernummer',
                'value' => $part->article_nr,
            ],
            [
                'label' => 'Kba',
                'value' => $part->article_nr,
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
}
