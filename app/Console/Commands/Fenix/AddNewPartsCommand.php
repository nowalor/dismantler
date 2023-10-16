<?php

namespace App\Console\Commands\Fenix;

use App\Actions\FenixAPI\Parts\GetPartsAction;
use App\Models\NewCarPart;
use App\Services\FenixApiService;
use Illuminate\Console\Command;

class AddNewPartsCommand extends Command
{
    private GetPartsAction $action;

    public function __construct()
    {
        parent::__construct();

        $this->action = new GetPartsAction();
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

        $filters = [
            "SbrPartCode" => ["7201", "7280", "7704", "7705", "7706", "7868", "7860", "7070", "7145"],
            "CarBreaker" => ["BO"],
        ];

        $response = $this->action->execute(
            filters: $filters,
            action: 1,
            createdDate: null,
        );

        $parts = $response['Parts'];

        foreach($parts as $part) {
        }

        logger($response);

        return Command::SUCCESS;
    }
}
