<?php

/*
 * Here we check if a part by us is sold on an outside platform
 * If a part is sold we should reserve it in the data provider
 * For example if a part we uploaded from the fenix API is sold on autoteile-markt.de
 * We then need to send a API request to fenix after getting the information from the autoteile-markt FTP
 * This can work differently depending on the platform and provider
 */
namespace App\Console\Commands;

use App\Console\Commands\Base\FenixApiBaseCommand;
use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ResolvePartsSoldByUsCommand extends FenixApiBaseCommand
{
    protected $signature = 'parts-we-sold:resolve';

    protected $description = 'Command description';

    public function handle()
    {
        $this->reservePart(NewCarPart::first());
        exit;

        $file = Storage::disk('ftp')->get('sellout_standard-testing.xml');

        $xml = simplexml_load_string($file);

        foreach ($xml->item as $item) {
            $articleNr = (string) $item->number;

            // Update part in DB
            $part = NewCarPart::where('article_nr', $articleNr)->first();

            if ($part) {
                $part->is_live = false;
                $part->sold_at = now();
                $part->sold_on_platform = 'autoteile-markt.de';

                $part->save();
            }

            // Send API request to Data Provider
            $this->reservePart($part);
        }

        return Command::SUCCESS;
    }
}
