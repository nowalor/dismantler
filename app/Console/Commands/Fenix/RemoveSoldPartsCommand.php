<?php

namespace App\Console\Commands\Fenix;

use App\Actions\Ebay\CreateDeleteXmlAction;
use App\Actions\Ebay\FtpFileUploadAction;
use App\Integration\Fenix\FenixClientInterface;
use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class RemoveSoldPartsCommand extends Command
{
    protected $signature = 'fenix:remove-sold-parts';

    public function handle(): int
    {
        $client = $this->client();

        $dismantlers = [
            'w',
            'p',
            'a',
            'bo',
            'f',
            'n',
            'al',
            's',
            'gb',
            'li',
            'd',
            'vi',
            'h',
            'as',
        ];

        $timestamp = Carbon::now()->subMinutes(15)->format('Y-m-d\TH:i:s.v\Z');

        $partIds = $client->getRemovedParts($dismantlers, $timestamp);

        foreach ($partIds as $partId) {
            $this->info($partId);
        }

        $parts = NewCarPart::whereIn('original_id', $partIds)->select([
            'id',
            'original_id',
            'article_nr',
        ])->get()->toArray();

        $this->handleSoldParts($parts);

        return Command::SUCCESS;
    }

    private function client(): FenixClientInterface
    {
        return resolve(FenixClientInterface::class, [
            'apiUrl' => config('services.fenix_api.base_uri'),
            'username' => config('services.fenix_api.email'),
            'password' => config('services.fenix_api.password'),
        ]);
    }

    private function handleSoldParts(array $parts): void
    {
        $this->info('handle sold parts');
        $this->info(count($parts));

        // This is all for autoteile-markt
        $this->generateCsv($parts);
        Storage::disk('ftp')->put('update.csv', file_get_contents(base_path('public/exports/update.csv')));

        // This is all for ebay
        $xmlName = (new CreateDeleteXmlAction())->execute($parts);
        (new FtpFileUploadAction())->execute(
            to: "store/deleteInventory",
            location: base_path("public/exports/$xmlName.xml"),
            fileName: "$xmlName.xml",
        );

        NewCarPart::whereIn('id', array_column($parts, 'id'))->update(['is_live' => false, 'sold_at' => now(), 'sold_on_platform' => 'fenix']);

        // HOOD
        (new \App\Actions\Hood\DeletePartsAction())->execute(collect($parts));
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
            $this->info('Removing part: ' . $part['article_nr']);

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
