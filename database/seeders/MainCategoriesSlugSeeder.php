<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainCategoriesSlugSeeder extends Seeder
{
    public function run()
    {
        // Fetch all main category records
        $mainCategories = DB::table('main_categories')->get();

        foreach ($mainCategories as $category) {
            // Generate slug from the name field (adjust 'name' if your column is named differently)
            $slug = Str::slug($category->name);

            // Update the record with the generated slug
            DB::table('main_categories')
                ->where('id', $category->id)
                ->update(['slug' => $slug]);
        }
    }
}
