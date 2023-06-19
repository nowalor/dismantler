<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\FenixApiBaseCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckFenixApiPartStatusCommand extends FenixApiBaseCommand
{
    private const PARTS = [
        [
            'id' => 22587890,
            'sbr_car_code' => '2483',
            'sbr_part_type_code' => '7860',
        ]
    ];


    protected $signature = 'fenix:check';

    protected $description = 'Command description';

    public function handle()
    {
        $this->authenticate();

        foreach (self::PARTS as $part) {
            $this->checkPartStatus($part);
        }

        return Command::SUCCESS;
    }

    private function checkPartStatus(array $part)
    {
        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            logger()->info('Token expired, re-authenticating');
            $this->authenticate();
        }
        $parts = [];

        $payload = [
            "Take" => 100,
            "Skip" => 0,
            "Page" => 1,
            "IncludeNew" => false,
            "PartImages" => true,
            "CarImages" => false,
            "IncludeSbrPartNames" => false,
            "IncludeSbrCarNames" => true,
            "IncludeFitsSbrCarCodes" => false,
            "ReturnOnlyPartCodes" => false,
            "ReturnOnlyCarCodes" => false,
            "MustHavePrice" => false,
            "CarBreaker" => "AT",
            "PartnerAccessLevel" => 2,
            "Filters" => [
                "SbrPartCode" => [
                    "7860"
                ],
                "SbrCarCode" => [
                    "2483"
                ]
            ],
            "SortBy" => [
                "Created" => "ASC"
            ],
            "Action" => 1
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);
        $response = $response->getBody();

        $parts[] = $response['parts'];

        logger()->info(json_encode($parts));
    }
}
