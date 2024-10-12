<?php

namespace App\Services;

use App\Models\DitoNumber;
use App\Models\NewCarPart;

class PartInformationService
{
    public function getNameForEbay(NewCarPart $carPart): string
    {
        $name = '';

        $germanCarPartName = $carPart->carPartType->germanCarPartTypes()->first()->name;

        if($germanCarPartName === 'Automatikgetriebe') {
            $germanCarPartName = 'ORIGINAL GETRIEBE AUTOMATIK';
        }

        if($germanCarPartName === 'Motor') {
            $germanCarPartName = 'ORIGINAL MOTOR';
        }

        $name .= $this->getCarName($carPart) . ' ' . $carPart->model_year;

        if (in_array(
            $carPart->car_part_type_id,
            [3, 4, 5],
            true)
        ) {
            $gearbox = $this->getGearbox($carPart);

            if (isset($gearbox) && $gearbox !== '') {
                $additionalInformation = $gearbox;
            } else {
                $additionalInformation = $carPart->engine_code;
            }
        } else {
            $additionalInformation = $carPart->engine_code;
        }

        $name .=  ' '  . $additionalInformation . ' ' . $germanCarPartName;

        $name .= ' ' . $carPart->original_number  . ' ' .  $carPart->mileage_km . 'KM';

        return preg_replace('/\s+/', ' ', $name);
    }

    public function getDescriptionName(NewCarPart $carPart): string
    {
        $name = '';

        $germanCarPartName = $carPart->carPartType->germanCarPartTypes()->first()->name;

        if($germanCarPartName === 'Automatikgetriebe') {
            $germanCarPartName = 'ORIGINAL Getriebe Automatik';
        }

        if($germanCarPartName === 'Motor') {
            $germanCarPartName = 'ORIGINAL Motor';
        }

        $name .= $germanCarPartName . ' ' . $this->getCarName($carPart) . ' ' . $carPart->model_year;

        return preg_replace('/\s+/', ' ', $name);
    }

    private function getCarName(NewCarPart $carPart): string
    {
        $country = $carPart->country;

        if($country === 'DK') {
//            $dito = DitoNumber::where('dito_number', $carPart->dito_number)->first();

            $dito = $carPart->ditoNumber;
            if(!$dito) {
                return $carPart->name;
            }
        } else {
            $dito = $carPart->sbrCode?->ditoNumbers()->first();

            if(!$dito) {
                return $carPart->sbr_car_name;
            }
        }

        return $dito->producer . ' ' . $dito->brand;
    }

    public function getGearbox(NewCarPart $carPart): string|null
    {
        if (
            $carPart->subgroup &&
            ($carPart->subgroup !== null || $carPart->subgroup !== '')
        ) {
            return $carPart->subgroup;
        }

        if (
            $carPart->gearbox_nr &&
            ($carPart->gearbox_nr !== null || $carPart->gearbox_nr !== '')
        ) {
            return $carPart->gearbox_nr;
        }

        return $carPart->gearbox;
    }
}
