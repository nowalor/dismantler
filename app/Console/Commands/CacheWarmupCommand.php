<?php

namespace App\Console\Commands;

use App\Models\MainCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

/*
 * This is where we put have caches we want to load one time a day
 */
class CacheWarmupCommand extends Command
{
    protected $signature = 'command:name';


    public function handle()
    {
        Cache::remember('main_categories_with_parts_count', 86400, function () {
            return MainCategory::select('main_categories.*')
                ->leftJoin('main_category_car_part_type', 'main_categories.id', '=', 'main_category_car_part_type.main_category_id')
                ->leftJoin('car_part_types', 'main_category_car_part_type.car_part_type_id', '=', 'car_part_types.id')
                ->leftJoin('new_car_parts', function ($join) {
                    $join->on('car_part_types.id', '=', 'new_car_parts.car_part_type_id')
                        ->whereNull('new_car_parts.sold_at');
                })
                ->groupBy('main_categories.id')
                ->selectRaw('count(new_car_parts.id) as new_car_parts_count')
                ->get();
        });

        return Command::SUCCESS;
    }
}
