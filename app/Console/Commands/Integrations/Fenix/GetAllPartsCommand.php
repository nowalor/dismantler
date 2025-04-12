<?php

namespace App\Console\Commands\Integrations\Fenix;

use App\Models\FenixPartImport;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Enums\FenixDismantlerEnum;
use App\Integration\Fenix\FenixClientInterface;
use App\Integration\Fenix\Actions\SaveFenixDtoInDbAction;

class GetAllPartsCommand extends Command
{
    protected $signature = 'fenix:get-all-parts';

    public function handle(): int
    {
        $importInfo = FenixPartImport::latest()->first();

        if(!$importInfo) {
            $importInfo = FenixPartImport::create([
                'dismantler' => FenixDismantlerEnum::W->value,
                'from_date' => now()->subWeek(),
                'to_date' => now(),
            ]);
        }

        $parts = $this->client()->getAllParts($importInfo->dismantler, $importInfo->from_date, $importInfo->to_date);
        foreach ($parts as $part) {
            (new SaveFenixDtoInDbAction)->execute($part);
        }

        // Logic for this could be nicer in the future...
        $isLastDismantler = $importInfo->dismantler === FenixDismantlerEnum::AS->value;

        if ($isLastDismantler) {
            // First dismantler from the enum going back a week
            FenixPartImport::create([
                'dismantler' => FenixDismantlerEnum::W->value,
                'from_date' => Carbon::parse($importInfo->from_date)->subWeek(),
                'to_date' => Carbon::parse($importInfo->to_date)->subWeek(),
            ]);
        } else {
            // Save the information about the dismantler we just got the info for
            FenixPartImport::create([
                'dismantler' => FenixDismantlerEnum::next($importInfo->dismantler),
                'from_date' => $importInfo->from_date,
                'to_date' => $importInfo->to_date,
            ]);
        }

        return Command::SUCCESS;

    }

    private function client(): FenixClientInterface
    {
        return resolve(FenixClientInterface::class, [
            'apiUrl' => config('services.fenix_api.base_uri'),
            'username' => config('services.fenix_api.email'),
            'password' => config('services.fenix_api.password'),
        ]);
    }
}
