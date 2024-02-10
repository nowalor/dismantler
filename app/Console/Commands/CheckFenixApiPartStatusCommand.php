<?php

namespace App\Console\Commands;

use App\Actions\Ebay\CreateDeleteXmlAction;
use App\Actions\Ebay\FtpFileUploadAction;
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
        $parts = NewCarPart::select([
            'id',
            'original_id',
            'article_nr',
            'is_live'
        ])->where('is_live', true)
            ->whereNull('sold_at')
            ->get()
            ->toArray();

        $this->authenticate();

        foreach ($parts as $part) {
            $isSold = $this->isPartSold(
                partId: $part['original_id'],
            );

            if ($isSold) {
                $this->soldParts[] = $part;
            }
        }

        $this->soldParts[] = NewCarPart::first();

        if (!empty($this->soldParts)) {
            $this->handleSoldParts();
        }

        return Command::SUCCESS;
    }

    private function handleSoldParts(): void
    {
        // This is all for autoteile-markt
        $this->generateCsv($this->soldParts);
        Storage::disk('ftp')->put('update.csv', file_get_contents(base_path('public/exports/update.csv')));

        // This is all for ebay
        $xmlName = (new CreateDeleteXmlAction())->execute($this->soldParts);
        (new FtpFileUploadAction())->execute(
            to: "store/deleteInventory",
            location: base_path("public/exports/$xmlName.xml"),
            fileName: "$xmlName.xml",
        );

        foreach ($this->soldParts as $part) {
            // Temporary code, TODO remove later
            if($part['article_nr'] === 'S544246') {
                logger('continuing the loop because article nr S544246');
                continue;
            }

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
