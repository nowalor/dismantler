<?php

namespace Database\Seeders;

use App\Models\MainCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MainCategoryCarPartTypePivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(base_path() . '/database/data/categories-part-types.json');
        $data = json_decode($file, true);

        foreach ($data as $item) {
            if (!isset($item['main_categories'])) {
                continue;
            }
            foreach ($item['main_categories'] as $mainCategory) {
                if (!isset($mainCategory['translation_key']) || !isset($mainCategory['pivot']) || !isset($mainCategory['pivot']['car_part_type_id']) ) {
                    continue;
                }

                $mainCategoryId = MainCategory::where('translation_key', $mainCategory['translation_key'])
                    ->first()->id;

                DB::table('main_category_car_part_type')
                    ->updateOrInsert([
                        'car_part_type_id' => $mainCategory['pivot']['car_part_type_id'],
                        'main_category_id' => $mainCategoryId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
        }
    }
}
