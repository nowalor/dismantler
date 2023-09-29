<?php

namespace App\Console\Commands\Fenix;

use App\Services\FenixApiService;
use Illuminate\Console\Command;

class AddNewPartsCommand extends Command
{
    public function __construct(private FenixApiService $fenixApiService)
    {
        parent::__construct();
    }

    protected $signature = 'fenix:add-new-parts';

    public function handle(): int
    {
        $dismantleCompanies = [
            "bo",
            'F',
            'A',
            'N',
        ];

        $options = [
              'Filters' => [
                  "SbrPartCode" => ["7201", "7280", "7704", "7705", "7706", "7868", "7860", "7070", "7145"],
                  "CarBreaker" => "updated from command",
              ],
            "CreatedDate" => "2023-09-11T09:00",
            "Action" => 55,
            "Test" => "test",
        ];

        $this->fenixApiService->getParts($options);

        return Command::SUCCESS;
    }
}
