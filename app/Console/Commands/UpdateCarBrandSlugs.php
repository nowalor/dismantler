<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CarBrand;
use Illuminate\Support\Str;

class UpdateCarBrandSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:car-brand-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update slugs for all car brands based on their names';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $brands = CarBrand::all();

        foreach ($brands as $brand) {
            $brand->slug = Str::slug($brand->name);
            $brand->save();

            $this->info("Updated slug for car brand: {$brand->name}");
        }

        $this->info('All car brand slugs have been updated!');
        return 0;
    }
}
