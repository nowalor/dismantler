<?php

namespace App\Actions\Hood;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use SimpleXMLElement;


class DeletePartsAction
{
    private string $username;
    private string $apiPassword;
    private Client $client;
    private string $apiUrl;

    public function __construct()
    {
        $this->username = config('services.hood.username');
        $this->apiPassword = config('services.hood.api_password');
        $this->apiUrl = config('services.hood.api_url');

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF-8',
                'Accept' => 'text/xml; charset=UTF-8',
            ],
        ]);
    }

    /*
     * Take in an array of article_nrs
     * Delete them from the hood.de web shop
     */
    public function execute(Collection $parts): void
    {
        if($parts->isEmpty()) {
            return;
        }

        $xml = $this->itemDeleteXml($parts);

        try {
            $response = $this->client->post(
                $this->apiUrl,
                [
                    'body' => $xml,
                ]
            );

            if($response->getStatusCode() ==! 200) {
                logger('Hood delete parts action failed, line 52');
            }

            logger($response->getBody()->getContents());
        } catch(\Exception $e) {
            logger($e->getMessage());
        }
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


    private function itemDeleteXml(Collection $parts): string
    {
        $xml = $this->baseXml();
        $xml->addChild('function', 'itemDelete');

        $itemsNode = $xml->addChild('items');

        foreach ($parts as $part) {
            $itemNode = $itemsNode->addChild('item');
            $itemNode->addChild('itemNumber', $part->article_nr);

            $part->is_live_on_hood = false;
            $part->save();
        }

        return $xml->asXML();
    }


}
