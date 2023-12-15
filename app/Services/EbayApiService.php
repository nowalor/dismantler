<?php


namespace App\Services;

use App\Helpers\Constants\EbayCsvHeader;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EbayApiService
{
    public function createListing()
    {
        $token = $this->getOAuthToken();

        $data = (new App\Actions\Ebay\BulkUploadPartsAction())->execute();
    }

    /*
     * Create a new empty CSV and add the header
     */
    public function createCsv(): void
    {
        $path = base_path('public/exports/ebay-import.csv');

        if(!empty(file_get_contents($path))) {
            return;
        }

        $file = fopen($path, 'a');

        fputcsv(
            $file,
            EbayCsvHeader::EBAY_CSV_HEADER,
            '|'
        );
    }

    public function addPartsToCsv()
    {
        $parts = NewCarPart::take(10)->get();


    }
}
