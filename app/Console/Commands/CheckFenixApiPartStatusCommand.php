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

    private array $soldParts = [];

    public function handle(): int
    {
        logger('CheckFenixApiPartStatusCommand ran on schedule');

        $parts = NewCarPart::select([
            'id',
            'original_id',
            'article_nr',
            'is_live'
        ])
            ->where('is_live', true)
            ->get()
            ->toArray();

        $this->authenticate();

        foreach ($parts as $part) {
            logger()->info('found part');
            logger($part);

            $isSold = $this->isPartSold(
                partId: $part['original_id'],
            );

            if ($isSold) {
                $this->soldParts[] = $part;
            }
        }

        if (!empty($this->soldParts)) {
            $this->handleSoldParts();
        }

        return Command::SUCCESS;
    }

    private function handleSoldParts(): void
    {
        $this->generateCsv($this->soldParts);
        Storage::disk('ftp')->put('update.csv', file_get_contents(base_path('public/exports/update.csv')));

        foreach ($this->soldParts as $part) {
            NewCarPart::where('id', $part['id'])->update(['is_live' => false, 'sold_at' => now(), 'sold_on_platform' => 'fenix']);
        }
    }

    private function generateCsv(array $parts): void
    {
        $path = base_path('public/exports/update.csv');

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
                0,
                0,
            ];
        }

        foreach ($rows as $row) {
            fputcsv($file, $row, '|');
        }
    }
}
