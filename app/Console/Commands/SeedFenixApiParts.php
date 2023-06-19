<?php

namespace App\Console\Commands;

use App\Models\SwedishCarPartType;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SeedFenixApiParts extends Command
{
    protected $signature = 'fenixapi:seed';

    protected $description = 'Command description';

    private Client $httpClient;

    private string $apiUrl;
    private string $email;
    private string $password;

    // API token
    private string $token;
    private string $tokenExpiresAt; //  "2023-06-19T08:53:12Z"

    public function __construct()
    {
        $this->apiUrl = config('services.fenix_api.base_uri');
        $this->email = config('services.fenix_api.email');
        $this->password = config('services.fenix_api.password');

        $this->httpClient  = new Client([
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        parent::__construct();
    }

    public function handle()
    {
        // Configuration
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);

        $this->authenticate();

        $swedishCarPartTypes = SwedishCarPartType::all();

//        foreach($swedishCarPartTypes as $swedishCarPartType) {
//            
//        }

        return Command::SUCCESS;
    }

    private function authenticate(): void
    {
        $payload = [
            'username' => $this->email,
            'password' => $this->password,
        ];

        logger(json_encode($payload));

        $response = $this->httpClient->post($this->apiUrl . '/account', [
            'body' => json_encode($payload),
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        $this->token = $responseBody['Token'];
        $this->tokenExpiresAt = $responseBody['Expiration'];
    }

    private function getParts(string $sbrCode): array
    {
        if($this->tokenExpiresAt < now()->toIso8601String()) {
            logger()->info('Token expired, re-authenticating');
            $this->authenticate();
        }

        $payload = [
            "Take" => 1000,
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
                    $sbrCode,
                ]
            ],
            "SortBy" => [
                "Created" => "ASC"
            ],
            "Action" => 1
        ];

    }
}
