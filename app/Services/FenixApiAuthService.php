<?php

namespace App\Services;

use GuzzleHttp\Client;

class FenixApiAuthService
{
    private Client $httpClient;
    private string $apiUrl;
    public function __construct()
    {

    }
}
