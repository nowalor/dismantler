<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\FenixApiBaseCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckFenixApiPartStatusCommand extends FenixApiBaseCommand
{
    private const PARTS = [
        [
            'id' => 22587895, // TODO: Change this to the correct ID
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

        $parts = [];

        foreach (self::PARTS as $part) {
            $response = $this->getParts(
                $part['sbr_part_type_code'],
                $part['sbr_car_code']
            );

            $parts[] = $response['Parts'][0]; // TODO check logic here
        }

        $this->partsFromApi = $parts;

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

        fputcsv($file, $header, '|');

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
            fputcsv($file, $row, '|');
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
}
