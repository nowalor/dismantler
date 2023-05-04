<?php

namespace Database\Seeders;

use App\Models\CarPartType;
use Illuminate\Database\Seeder;

class AddArticleNrToCarPartTypeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 3574,
                'autoteile_markt_article_nr' => 193
            ],
            [
                'id' => 3616,
                'autoteile_markt_article_nr' => 840
            ],
            [
                'id' => 3617,
                'autoteile_markt_article_nr' => 838

            ],
            [
                'id' => 3744,
                'autoteile_markt_article_nr' => 851
            ],
            [
                'id' => 3746,
                'autoteile_markt_article_nr' => 851

            ],
            [
                'id' => 3749,
                'autoteile_markt_article_nr' => 852
            ],
            [
                'id' => 3812,
                'autoteile_markt_article_nr' => 939
            ],
        ];

        foreach ($data as $item) {
            CarPartType::find($item['id'])->update([
                'autoteile_markt_article_nr' => $item['autoteile_markt_article_nr']
            ]);
        }
    }
}
