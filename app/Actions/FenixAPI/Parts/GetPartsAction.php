<?php

namespace App\Actions\FenixAPI\Parts;

use App\Actions\FenixAPI\FenixApiAction;
use Exception;

class GetPartsAction extends FenixApiAction
{
    public function execute(
        array  $filters,
        int    $take = 500,
        int    $skip = 0,
        int    $page = 1,
        int    $action = 1,
        string $createdDate = null,
    ): bool|array
    {
        $this->authenticate();

        $payload = [
            "Take" => $take,
            "Skip" => $skip,
            "Page" => $page,
            "IncludeNew" => false,
            "PartImages" => true,
            "IncludeSbrCarNames" => true,
            "MustHavePrice" => true,
            "CarBreaker" => "AT",
            "PartnerAccessLevel" => 2,
            "Filters" => $filters,
            "CreatedDate" => $createdDate,
            "SortBy" => [
                "Created" => "ASC"
            ],
            "Action" => $action
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        try {
            $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);

            if ($response->getStatusCode() !== 200) {
                logger()->error("Fenix API error: " . $response->getBody()->getContents());

                return false;
            }

            logger()->info("Fenix API response: " . $response->getBody()->getContents());

            $data = json_decode(
                $response->getBody()->getContents(),
                true,
//                512,
//                JSON_THROW_ON_ERROR,
            );

            logger($data);
        } catch (Exception $e) {
            logger()->error("Fenix API error: " . $e->getMessage());

            return false;
        }

        return $data;
    }
}
