<?php

namespace App\Console\Commands\Fenix\Images;

use App\Models\NewCarPartImage;
use Illuminate\Console\Command;

class FindCarPartIdForImageCommand extends Command
{
    protected $signature = 'fenix-images:find-car-part-id';


    public function handle(): int
    {
        $images = NewCarPartImage::whereNull('new_car_part_id')
            ->whereNotNull('article_nr_at_carbreaker')
            ->take(5000)
            ->get();

        if ($images->isEmpty()) {
            $this->info('No images found needing update.');
            return Command::SUCCESS;
        }

        $articleNumbers = $images->pluck('article_nr_at_carbreaker')->unique();

        $partMap = \App\Models\NewCarPart::whereIn('article_nr_at_dismantler', $articleNumbers)
            ->pluck('id', 'article_nr_at_dismantler'); // [article_nr => id]

        $updates = [];

        foreach ($images as $image) {
            $articleNr = $image->article_nr_at_carbreaker;
            if (isset($partMap[$articleNr])) {
                $updates[] = [
                    'id' => $image->id,
                    'new_car_part_id' => $partMap[$articleNr],
                ];
            }
        }

        collect($updates)->chunk(500)->each(function ($chunk) {
            foreach ($chunk as $update) {
                NewCarPartImage::where('id', $update['id'])->update([
                    'new_car_part_id' => $update['new_car_part_id'],
                ]);
            }
        });

        $this->info("Updated " . count($updates) . " image(s).");

        return Command::SUCCESS;
    }

}
