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
        $this->dbParts = NewCarPart::select(['id', 'original_id', 'sbr_part_code', 'sbr_car_code', 'article_nr', 'price'])
            ->where('is_live', true)
            ->get()
            ->toArray();

        $this->authenticate();

        $parts = [];

        foreach ($this->dbParts as $part) {
            $response = $this->getParts(
                $part['sbr_part_code'],
                $part['sbr_car_code']
            );

            $parts[] = $response['parts']; // TODO check logic here
        }

        $this->partsFromApi = $parts[0];

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
                logger()->info('------------ PART BEGIN ------------');
                logger($part);
                logger()->info('------------ PART END ------------');
//                if ($part[0][0]['Id'] === $partToCheck['original_id'] && $part[0][0]['SbrCarCode'] === $partToCheck['sbr_car_code'] && $part[0][0]['SbrPartCode'] === $partToCheck['sbr_part_code']) {
//                    $found = true;
//
//                    break; // Exit the loop if the part is found
//                }
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

        foreach($this->soldParts as $part) {
            NewCarPart::where('id', $part['id'])->update(['is_live' => false, 'sold_at' => now()]);
        }
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
