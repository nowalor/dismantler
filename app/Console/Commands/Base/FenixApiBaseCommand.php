<?php

namespace App\Console\Commands\Base;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

abstract class FenixApiBaseCommand extends Command
{
    protected Client $httpClient;

    protected string $apiUrl;
    protected string $email;
    protected string $password;

    // API token
    protected string $token;
    protected string $tokenExpiresAt; //  "2023-06-19T08:53:12Z"

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
}
