<?php

namespace App\Services;

use App\Models\NewCarPart;

class PartInformationService
{
    public function getNameForEbay(NewCarPart $carPart): string
    {
        // 3,4 5
        $name = '';

        $germanCarPartName = $carPart->carPartType->germanCarPartTypes()->first()->name;

        $name .= $germanCarPartName . ' ' . $carPart->brand_name . ' ' . $carPart->model_year . ' ' . $carPart->original_number . ' ';

        if(in_array([3, 4, 5], $carPart->carPartType->id)) {
            $additionalInformation = $this->getGearbox($carPart);
        } else {
            $additionalInformation = $carPart->engine_code;
            
        }

        $name .= $additionalInformation . ' ' . $carPart->vin;

        return $name;
    }

    public function getGearbox(NewCarPart $carPart): string
    {
        if($carPart->subgroup) {
            return $carPart->subgroup;
        }

        if($carPart->gearbox_nr){
            return $carPart->gearbox_nr;
        }

        return $carPart->gearbox;
    }
}
