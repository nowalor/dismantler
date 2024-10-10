<?php

namespace App\Actions;

use App\Models\DitoNumber;
use App\Models\GermanDismantler;
use DOMDocument;
use Http;

class SearchNumberplateAction
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://www.nummerplade.net/nummerplade';
    }

    public function execute(string $numberPlate)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');

        $response = Http::get("{$this->baseUrl}/$numberPlate.html");

        $responseBody = $response->body();

        @$dom->loadHTML($responseBody);

        $make = $dom->getElementById('maerke')->nodeValue;
        $model = $dom->getElementById('model')->nodeValue;

        $kba = GermanDismantler::where('commercial_name', $model)->first();

        return $kba->newCarParts;

/*        $normalizedValues = $this->normalize($make, $model);

        $ditoNumber = DitoNumber::where([]);*/
    }

    private function normalize(string $make, string $model): array
    {
        $normalizedMake = match ($make) {
            'Polestar' => 'Polestar',
        };

        $normalizedModel = match ($model) {
            'Polestar 2' => '2',
        };

        return [$normalizedMake, $normalizedModel];
    }
}
