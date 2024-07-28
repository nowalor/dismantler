<?php

namespace App\Console\Commands\Hood;

use App\Models\NewCarPart;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use SimpleXMLElement;

class DeletePartsCommand extends Command
{
    protected $signature = 'hood:delete';

    private string | null $username;
    private string | null $apiPassword;

    public function __construct()
    {
        parent::__construct();

        $this->username = config('services.hood.username');
        $this->apiPassword = config('services.hood.api_password');

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF-8',
                'Accept' => 'text/xml; charset=UTF-8',
            ],
        ]);

        $this->apiUrl = config('services.hood.api_url');
    }

    public function handle(): int
    {
        $itemListXml = $this->itemListXml();




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

//        $existingItems = $this->getItems();
//
////        $items = $xml->addChild('items');
//
//        foreach($parts as $part) {
//
//        }
    }

    private function itemListXml()
    {
        $xml = $this->baseXml();
        $xml->addChild('function', 'itemDelete');
        $xml->addChild('itemStatus', 'shopInventory');
        $xml->addChild('listMode', 'simple');
        $xml->addChild('startAt', '1');
        $xml->addChild('groupSize', '500');


    }

    private function getItems(): array
    {

    }
}
