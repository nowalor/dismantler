<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\FenixApiBaseCommand;
use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckFenixApiPartStatusCommand extends FenixApiBaseCommand
{
    protected $signature = 'fenix:check';

    protected $description = 'Command description';

    private array $partsFromApi = [];
    private array $soldParts = [];
    private array $dbParts;

    public function handle(): int
    {
        $this->dbParts = NewCarPart::select(['id', 'sbr_part_code', 'sbr_car_code', 'article_nr', 'price'])->get()->toArray();

        $this->authenticate();

        $parts = [];

        foreach ($this->dbParts as $part) {
            $response = $this->getParts(
                $part['sbr_part_code'],
                $part['sbr_car_code']
            );

            $parts[] = $response['parts']; // TODO check logic here
        }

        $this->partsFromApi = $parts;

        $this->checkForSoldParts();

        if (!empty($this->soldParts)) {
            $this->handleSoldParts();
        }

        return Command::SUCCESS;
    }

    private function checkForSoldParts(): void
    {
        foreach ($this->dbParts as $partToCheck) {
            $found = false;

            foreach ($this->partsFromApi as $part) {
                if ($part[0][0]['Id'] === $partToCheck['id'] && $part[0][0]['SbrCarCode'] === $partToCheck['sbr_car_code'] && $part[0][0]['SbrPartCode'] === $partToCheck['sbr_part_code']) {
                    $found = true;

                    break; // Exit the loop if the part is found
                }
            }

            if (!$found) {
                $this->soldParts[] = $partToCheck;
            }
        }
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
        foreach ($parts as $part) {
            logger($part);
            $rows[] = [
                $part['article_nr'],
                0,
                "1200.0",
                "1200.0",
            ];
        }

        foreach ($rows as $row) {
            fputcsv($file, $row, '|');
        }
    }
}
