<?php
/*
namespace App\Console\Commands\Hood;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use SimpleXMLElement;

class DeletePartsCommand extends Command
{
    protected $signature = 'hood:delete';

    private ?string $username;
    private ?string $apiPassword;
    private Client $client;
    private ?string $apiUrl;

    public function __construct()
    {
        parent::__construct();

        $this->username = config('services.hood.username');
        $this->apiPassword = config('services.hood.api_password');
        $this->apiUrl = config('services.hood.api_url');

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF-8',
                'Accept' => 'text/xml; charset=UTF-8',
            ],
        ]);

        logger('hood delete command still running??');
        logger("url $this->apiUrl");
    }

    public function handle(): int
    {
        do {
            $itemListXml = $this->itemListXml();

            $response = $this->client->post(
                $this->apiUrl,
                [
                    'body' => $itemListXml,
                ]
            );

            $responseBody = $response->getBody()->getContents();
            $itemsXml = $this->extractItemsXml($responseBody);

            // Check if there was an error indicating no auctions found
            if ($itemsXml === null) {
                logger("No more items to delete.");
                break;
            }

            $deleteAsXML = $this->itemDeleteXml($itemsXml);

            logger($deleteAsXML);

            $response = $this->client->post(
                $this->apiUrl,
                [
                    'body' => $deleteAsXML,
                ]
            );

            // Optional: Log response from delete request
            logger($response->getBody()->getContents());

        } while (false);

        return Command::SUCCESS;
    }

    private function baseXml(): SimpleXMLElement
    {
        $xml = new SimpleXMLElement(
            "<?xml version='1.0' encoding='UTF-8'?>
            <api
                user='$this->username'
                type='public'
                version='2.0'
                password='$this->apiPassword'
            ></api>"
        );
        $xml->addChild('accountName', $this->username);
        $xml->addChild('accountPass', $this->apiPassword);

        return $xml;
    }

    private function itemDeleteXml(SimpleXMLElement $items): string
    {
        $xml = $this->baseXml();
        $xml->addChild('function', 'itemDelete');

        $itemsNode = $xml->addChild('items');

        foreach ($items->item as $item) {
            $itemNode = $itemsNode->addChild('item');
            $itemNode->addChild('recordSet', $item->recordSet);
            $itemNode->addChild('itemID', $item->itemID);
        }

        return $xml->asXML();
    }

    private function itemListXml()
    {
        $xml = $this->baseXml();
        $xml->addChild('function', 'itemList');
        $xml->addChild('itemStatus', 'shopInventory');
        $xml->addChild('listMode', 'simple');
        $xml->addChild('startAt', '1');
        $xml->addChild('groupSize', '500');

        // Optional Parameters
        $dateRange = $xml->addChild('dateRange');
        $dateRange->addChild('startDate', ''); // Optional, leave blank if not needed
        $dateRange->addChild('endDate', '');   // Optional, leave blank if not needed

        $xml->addChild('itemID', '');          // Optional, leave blank if not needed
        $xml->addChild('itemNumber', '');      // Optional, leave blank if not needed

        return $xml->asXML();
    }

    private function extractItemsXml(string $responseBody): ?SimpleXMLElement
    {
        $xml = new SimpleXMLElement($responseBody);

        // Check if the response contains an error
        if (isset($xml->error) && (string)$xml->error === 'No auctions found.') {
            return null; // Indicate no items to process
        }

        return $xml->items;
    }
}*/
