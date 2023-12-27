<?php

namespace App\Actions\Parts;

use App\Models\GermanDismantler;

class SearchByKbaAction
{
    public function execute(
        string $hsn,
        string $tsn,
    ): array
    {

        $germanDismantler = GermanDismantler::where('hsn', $hsn)
            ->where('tsn', $tsn)
            ->first();

        if(!$germanDismantler) {
            return [
              'success' => false,
              'message' => "Kba not found, if you are sure it's typed correctly please contact us to let us know we are missing the kba",
            ];
        }

        $parts = $germanDismantler->newCarParts->load('carPartImages');

        if(!$parts) {
            return [
                'success' => false,
                'message' => "No parts found matching the kba",
            ];
        }

        return [
            'success' => true,
            'data' => $parts,
        ];
    }
}
