<?php


namespace App\Services;

use App\Actions\Ebay\FtpFileUploadAction;
use App\Helpers\Constants\EbayCsvHeader;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\NewCarPart;
use App\Actions\Ebay\FormatPartsForXmlAction;
use App\Actions\Ebay\AddProductToXmlFileAction;
use Illuminate\Database\Eloquent\Collection;

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

    public function handlePartUpload(Collection $parts): bool
    {
        $formattedParts = (new FormatPartsForXmlAction())->execute($parts);

        $xmlName = (new AddProductToXmlFileAction())->execute($formattedParts);

        return (new FtpFileUploadAction())->execute(
            '/store/product',
            base_path("public/exports/$xmlName"),
            $xmlName,
        );
    }
}
