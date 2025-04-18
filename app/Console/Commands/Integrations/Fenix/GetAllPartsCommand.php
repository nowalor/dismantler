<?php

namespace App\Console\Commands\Integrations\Fenix;

use App\Models\FenixPartImport;
use App\Models\NewCarPart;
use App\Models\NewCarPartImage;
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
                'from_date' => now()->subDay(),
                'to_date' => now(),
            ]);
        }

        [$parts, $images] = $this->client()->getAllParts($importInfo->dismantler, $importInfo->from_date, $importInfo->to_date);

        $existingIds = NewCarPart::whereIn('original_id', collect($parts)->pluck('original_id'))
            ->pluck('original_id')
            ->all();

        logger('Existing ids:', $existingIds);

        $parts = collect($parts)->filter(function ($part) {
            $price = $part->price_sek;

            // Log and skip invalid prices
            if (!is_numeric($price)) {
                logger("Skipping part with non-numeric price: " . json_encode($part));
                return false;
            }

            if ($price < 0) {
                logger("Skipping part with price < 0: " . json_encode($part));
                return false;
            }

            if ($price >= 99999999.99) {
                logger("Skipping part with very high price: " . json_encode($part));
                return false;
            }

            return true;
        })->values()->all();

        $newParts = collect($parts)->reject(fn($part) => in_array($part->original_id, $existingIds))->values();

        $mappedParts = $newParts->map(fn($part) => [
            'original_id' => $part->original_id,
            'price_sek' => $part->price_sek,
            'data_provider_id' => 1,
            'sbr_part_code' => $part->sbr_part_code,
            'sbr_car_code' => $part->sbr_car_code,
            'original_number' => $part->original_number,
            'quality' => $part->quality,
            'dismantled_at' => $part->dismantled_at,
            'engine_code' => $part->engine_code ?? null,
            'engine_type' => $part->engine_type ?? null,
            'dismantle_company_name' => $part->dismantle_company_name,
            'article_nr_at_dismantler' => $part->article_nr_at_dismantler,
            'sbr_car_name' => $part->sbr_car_name ?? null,
            'body_name' => $part->body_name ?? null,
            'fuel' => $part->fuel ?? null,
            'gearbox' => $part->gearbox ?? null,
            'warranty' => $part->warranty,
            'mileage_km' => (int)($part->mileage ?? 0) * 10,
            'mileage' => (int)($part->mileage ?? 0),
            'model_year' => $part->model_year ?? null,
            'vin' => $part->vin ?? null,
            'originally_created_at' => $part->original_created_at ?? null,
        ]);

        $mappedParts->chunk(500)->each(function ($chunk){
            NewCarPart::insert($chunk->all());
        });

        foreach(array_chunk($images, 500) as $imageChunk ) {
            NewCarPartImage::insert($imageChunk);
        }

        // Logic for this could be nicer in the future...
        $isLastDismantler = $importInfo->dismantler === FenixDismantlerEnum::H->value;

        if ($isLastDismantler) {
            // First dismantler from the enum going back a week
            FenixPartImport::create([
                'dismantler' => FenixDismantlerEnum::W->value,
                'from_date' => Carbon::parse($importInfo->from_date)->subDay(),
                'to_date' => Carbon::parse($importInfo->to_date)->subDay(),
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
