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
use SimpleXMLElement;

class ResolvePartsSoldByUsCommand extends FenixApiBaseCommand
{
    protected $signature = 'parts-we-sold:resolve';

    protected $description = 'Command description';

    public function handle()
    {
        $parts = $this->getSoldParts();

        if(count($parts)) {
            $this->handleSoldParts($parts);
        }

        $this->reservePart(NewCarPart::first());
        exit;

        return Command::SUCCESS;
    }

    /*
     * Go through all the sold parts
     * Reserve them in the data provider
     * Update the part in the database
     */
    private function handleSoldParts(array $parts)
    {
        foreach($parts as $part) {
            $success = $this->reservePart($part);

            if($success) {
                $this->updadatePartInDB($part['article_nr']);
            }
        }
    }

    /*
     * Make a request to the autoteile-markt FTP server
     * Sold parts will be in the sellout_standard.xml file
     */
    private function getSoldParts(): array
    {
        $file = Storage::disk('ftp')->get('sellout_standard-testing.xml');

        $xml = simplexml_load_string($file);

        $parts = [];

        foreach ($xml->item as $item) {
            $articleNr = (string)$item->number;

            // Extract billing address details
            $billingAddress = $xml->head->billingadress;
            $billingInformation = $this->extractInformation($billingAddress);

            // Extract shipping address details
            $shippingAddress = $xml->head->shippingadress;
            $shippingInformation = $this->extractInformation($shippingAddress);

            $soldPart = [
                'article_nr' => $articleNr,
                'billing_information' => $billingInformation,
                'shipping_information' => $shippingInformation,
            ];

            $parts[] = $soldPart;

        }

        return $parts;
    }

    private function updadatePartInDB(string $articleNr)
    {
        $part = NewCarPart::where('article_nr', $articleNr)->first();

        if ($part) {
            $part->is_live = false;
            $part->sold_at = now();
            $part->sold_on_platform = 'autoteile-markt.de';

            $part->save();
        }
    }

    private function extractInformation(SimpleXMLElement $item): array
    {
        $data =  [
            'firstname' => (string)$item->firstname,
            'surname' => (string)$item->surname,
            'street' => (string)$item->street,
            'zip' => (string)$item->zip,
            'city' => (string)$item->city,
            'country' => (string)$item->country,
            'phone' => (string)$item->phone,
        ];

        if($item->email) {
            $data['email'] = (string)$item->email;
        }

        return $data;
    }
}
