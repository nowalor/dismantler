<?php

namespace App\Services;

use App\Models\NewCarPart;

class PartInformationService
{
    public function resolveGearbox(NewCarPart $carPart): string
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
