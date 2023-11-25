<?php

namespace App\Services;

use App\Models\NewCarPart;

class PartInformationService
{
    public function getNameForEbay(NewCarPart $carPart): string
    {
        $name = '';

        $germanCarPartName = $carPart->carPartType->germanCarPartTypes()->first()->name;

        $name .= $germanCarPartName . ' ' . $carPart->brand_name . ' ' . $carPart->model_year . ' ' . $carPart->original_number . ' ';

        if(in_array([3, 4, 5], $carPart->car_part_type_id, true)) {
            $gearbox = $this->getGearbox($carPart);

             if(isset($gearbox) && $gearbox !== '') {
                 $additionalInformation = $gearbox;
             } else {
                 $additionalInformation = $carPart->engine_code;
             }
        } else {
            $additionalInformation = $carPart->engine_code;
        }

        $name .= $additionalInformation . ' ' . $carPart->vin;

        return $name;
    }

    public function getGearbox(NewCarPart $carPart): string | null
    {
        if(
            $carPart->subgroup &&
            ($carPart->subgroup !== null || $carPart->subgroup !== '')
        ) {
            return $carPart->subgroup;
        }

        if(
            $carPart->gearbox_nr &&
            ($carPart->gearbox_nr !== null || $carPart->gearbox_nr !== '')
        ){
            return $carPart->gearbox_nr;
        }

        return $carPart->gearbox;
    }
}
