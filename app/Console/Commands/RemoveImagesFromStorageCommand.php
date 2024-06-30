<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class RemoveImagesFromStorageCommand extends Command
{
    protected $signature = 'file-storage:purge';

    public function handle(): int
    {
        $parts = $this->parts();

        $this->info($parts->count());

        foreach($parts as $part) {
            Storage::disk('do')->deleteDirectory("img/car-part/{$part->id}/german-logo");
            Storage::disk('do')->deleteDirectory("img/car-part/{$part->id}/new-logo");

            $part->carPartImages()->update(['new_logo_german' => null]);
        }

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        return NewCarPart::select(["id", "dismantle_company_name"])
            ->whereHas('carPartImages', function ($query) {
                $query->whereNotNull('new_logo_german');
            })
            ->whereIn('external_part_type_id', CarPart::CAR_PART_TYPE_IDS_TO_INCLUDE)
//            ->whereNull('sold_at')
            ->take(1000)
            ->get();
    }
}
