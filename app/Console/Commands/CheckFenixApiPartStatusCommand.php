<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\FenixApiBaseCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckFenixApiPartStatusCommand extends FenixApiBaseCommand
{
    private const PARTS = [
        [
            'id' => 22587891, // TODO: Change this to the correct ID
            'sbr_car_code' => '2483',
            'sbr_part_type_code' => '7860',
        ]
    ];

    protected $signature = 'fenix:check';

    protected $description = 'Command description';

    private array $partsFromApi = [];
    private array $soldParts = [];

    public function handle(): int
    {
        $this->authenticate();

        foreach (self::PARTS as $part) {
            $this->getParts($part);
        }

        $this->checkForSoldParts();

        if(!empty($this->soldParts)) {
            $this->handleSoldParts();
        }

        return Command::SUCCESS;
    }

    private function handleSoldParts(): void
    {
        $this->generateCsv($this->soldParts);
        Storage::disk('ftp')->put('update-test.csv', file_get_contents(base_path('public/exports/update-test.csv')));
    }

    private function generateCsv(array $parts): void
    {
        $path = base_path('public/exports/update-test.csv');

        $file = fopen($path, 'w');

        $header = [
            'article_nr',
            'quantity',
            'price',
            'price_b2b'
        ];

        fputcsv($file, $header);

        $rows = [];
        foreach($parts as $part) {
            $rows[] = [
                $part['id'],
                0,
                500,
                500,
            ];
        }

        foreach ($rows as $row) {
            fputcsv($file, $row);
        }
    }

    private function checkForSoldParts(): void
    {
        foreach (self::PARTS as $partToCheck) {
            $found = false;

            foreach ($this->partsFromApi as $part) {
                if ($part['Id'] === $partToCheck['id'] && $part['SbrCarCode'] === $partToCheck['sbr_car_code'] && $part['SbrPartCode'] === $partToCheck['sbr_part_type_code']) {
                    $found = true;

                    break; // Exit the loop if the part is found
                }
            }

            if (!$found) {
                $this->soldParts[] = $partToCheck;
            }
        }
    }

    private function getParts(array $part): void
    {
        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }
        $parts = [];

        $payload = [
            "Take" => 100,
            "Skip" => 0,
            "Page" => 1,
            "IncludeNew" => false,
            "PartImages" => true,
            "CarImages" => false,
            "IncludeSbrPartNames" => false,
            "IncludeSbrCarNames" => true,
            "IncludeFitsSbrCarCodes" => false,
            "ReturnOnlyPartCodes" => false,
            "ReturnOnlyCarCodes" => false,
            "MustHavePrice" => false,
            "CarBreaker" => "AT",
            "PartnerAccessLevel" => 2,
            "Filters" => [
                "SbrPartCode" => [
                    "7860"
                ],
                "SbrCarCode" => [
                    "2483"
                ]
            ],
            "SortBy" => [
                "Created" => "ASC"
            ],
            "Action" => 1
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);
        $response = json_decode($response->getBody(), true);

        $parts[] = $response['Parts'][0];

        $this->partsFromApi = $parts;
    }
}
