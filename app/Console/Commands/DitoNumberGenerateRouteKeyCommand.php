<?php

namespace App\Console\Commands;

use App\Models\DitoNumber;
use Illuminate\Console\Command;
use Str;

class DitoNumberGenerateRouteKeyCommand extends Command
{
    protected $signature = 'dito:generate-route-keys';

    public function handle()
    {
        DitoNumber::chunk(500, function ($records) {
            foreach ($records as $dito) {
                $brand = Str::slug($dito->producer);   // or $this->brand depending on your naming
                $model = Str::slug($dito->brand);      // "brand" here is car model like "Micra K12"
                $year = Str::slug($dito->standardized_production_date); // e.g. 2003-2010

                $routeKey = "{$brand}-{$model}";

                if($year) {
                     $routeKey .= "-{$year}";
                }

                $dito->route_key = $routeKey;
                $dito->save();
                $this->info("Generated route_key for ID {$dito->id} ➔ {$dito->route_key}");
            }
        });

        $this->info('All route keys generated!');
    }
}
