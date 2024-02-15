<?php

namespace App\Actions\Ebay;

class BulkUploadPartsAction extends EbayAction
{
    public function execute(): array
    {
        try {
            $response = $this->client->post(
                $this->apiUrl . '/sell/inventory/v1/bulk_create_or_replace_inventory_item',
                [
                    'json' => $payload,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                    ],
                ],
            );

            $data = json_decode(
                $response->getBody()->getContents(),
                true, 512, JSON_THROW_ON_ERROR
            );

            return $data;
        } catch (
        GuzzleHttp\Exception\ClientException |
        GuzzleHttp\Exception\ServerException $e
        ) {
            if (
                $e->getResponse()->getStatusCode() === 400 ||
                $e->getResponse()->getStatusCode() === 401
            ) {
                logger($e->getResponse()->getBody()->getContents());
            } else {
                throw $e;
            }
        }
    }
    private function formatPayload(): array
    {
        $payload = [
            "requests" => [
                [
                    "condition" => "NEW",
                    "conditionDescription" => "string",
                    "conditionDescriptors" => [
                        [
                            "additionalInfo" => "string",
                            "name" => "string",
                            "values" => [
                                "string"
                            ]
                        ]
                    ],
                    "locale" => "en_US",
                    "product" => [
                        "aspects" => [
                            "Brand" => [
                                "GoPro"
                            ],
                            "Type" => [
                                "Helmet/Action"
                            ],
                            "Storage Type" => [
                                "Removable"
                            ],
                            "Recording Definition" => [
                                "High Definition"
                            ],
                            "Media Format" => [
                                "Flash Drive (SSD)"
                            ],
                            "Optical Zoom" => [
                                "10x"
                            ]
                        ],
                        "brand" => "GoPro",
                        "description" => "string",
                        "ean" => [
                            "string"
                        ],
                        "epid" => "string",
                        "isbn" => [
                            "string"
                        ],
                        "mpn" => "string",
                        "subtitle" => "string",
                        "title" => "string",
                        "upc" => [
                            "string"
                        ],
                        "videoIds" => [
                            "string"
                        ]
                    ],
                    "sku" => "string"
                ]
            ]
        ];

        return $payload;
    }
}
