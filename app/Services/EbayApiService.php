<?php


namespace App\Services;

use App\Helpers\Constants\EbayCsvHeader;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\NewCarPart;
use App\Actions\Ebay\FormatPartsForCsvAction;
use App\Actions\Ebay\AddProductToXmlFileAction;

class EbayApiService
{
    public function createListing()
    {
        $token = $this->getOAuthToken();

        /*
         * $data = (new App\Actions\Ebay\BulkUploadPartsAction())->execute();
         * This one is currently not used
         * TODO: delete it if we stick with using XML to upload instead
         */
    }

    /*
     * Create a new empty CSV and add the header
     * Not used at the moment
     * TODO delete it if we stick with XML instead
     */
    public function createCsv(): void
    {
        $path = base_path('public/exports/ebay-import.csv');

        if (!empty(file_get_contents($path))) {
            return;
        }

        $file = fopen($path, 'a');

        fputcsv(
            $file,
            EbayCsvHeader::EBAY_CSV_HEADER,
            '|'
        );
    }

    public function addPartsToXml(): void
    {
        $parts = NewCarPart::take(1)->get();

        $formattedParts = (new FormatPartsForCsvAction())->execute($parts);

        $data = [
            'productRequest' => $formattedParts,
        ];

        (new AddProductToXmlFileAction())->execute($data);
    }
}
