<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NewCarPart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RenameImageNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:renameImageNames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this script is for renaming the files from for example "image1.jpg", to something more telling for SEO optimization.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Load a small batch of 10 car parts to rename:
        $carParts = NewCarPart::limit(10)->get();

        foreach ($carParts as $part) {
            // Make a slug from the car’s name, e.g. “Toyota Corolla” -> “toyota-corolla”
            $carNameSlug = Str::slug($part->sbr_car_name, '-');
            $counter = 1;

            // Assuming you have a hasMany relationship on NewCarPart -> images
            // e.g. public function images() { return $this->hasMany(NewCarPartImage::class); }
            foreach ($part->images as $image) {
                // Check if this image is named something like "image1.jpg"
                // so we don’t rename “already fine” files
                if (Str::startsWith($image->new_logo_german, 'image')) {

                    // Extract the current extension
                    $extension = pathinfo($image->new_logo_german, PATHINFO_EXTENSION);

                    // Generate the new file name, e.g.: "toyota-corolla-1.jpg"
                    $newFileName = $carNameSlug . '-' . $counter . '.' . $extension;

                    // Build the old and new paths for DigitalOcean Spaces
                    $oldPath = "img/car-part/{$part->id}/german-logo/{$image->new_logo_german}";
                    $newPath = "img/car-part/{$part->id}/german-logo/{$newFileName}";

                    // Attempt to move (rename) in DigitalOcean Spaces
                    try {
                        Storage::disk('spaces')->move($oldPath, $newPath);

                        // Update the DB column so future references point to the new file
                        $image->new_logo_german = $newFileName;
                        $image->save();

                        $counter++;
                        $this->info("Renamed $oldPath -> $newPath");
                    } catch (\Exception $e) {
                        // Log or handle any errors here
                        $this->error("Failed to rename $oldPath: " . $e->getMessage());
                    }
                }
            }
        }

        $this->info('Renaming complete for this batch of 10 car parts.');
        return Command::SUCCESS;
    }
}
