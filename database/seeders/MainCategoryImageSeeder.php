<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainCategoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainCategoryImages = [
            [
                // body parts
                'image' => '',
                'id' => 43,
            ],
            [
                // fuel system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/tank.png',
                'id' => 44,
            ],
            [
                // audio/communication system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/audio-system.png',
                'id' => 45,
            ],
            [
                // brake system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/break.png',
                'id' => 46,
            ],
            [
                // gearbox/transmission
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/gearkasse.png',
                'id' => 47,
            ],
            [
                // chassis/steering
                'image' => '',
                'id' => 48,
            ],
            [
                // cooling/heating/aircon
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/air-conditioner.png',
                'id' => 49,
            ],
            [
                // switches/relays/sensor
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/switch.png',
                'id' => 50,
            ],
            [
                // looks/locking system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/look.png',
                'id' => 51,
            ],
            [
                // wipers
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/wiper.png',
                'id' => 52,
            ],
            [
                // interior
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/interior.png',
                'id' => 53,
            ],
            [
                // electronic parts
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/electronic-parts.png',
                'id' => 54,
            ],
            [
                // lights/mirrors
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/lights-mirrors.png',
                'id' => 55,
            ],
            [
                // engine/engine parts
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/car-engine.png',
                'id' => 56,
            ],
            [
                // exhaust system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/exhaust-system.png',
                'id' => 57,
            ],
            [
                // instruments
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/instruments.png',
                'id' => 58,
            ]
        ];

        foreach ($mainCategoryImages as $image) {
            DB::table('main_categories')
                ->where('id', $image['id'])
                ->update(['image' => $image['image']]);
        }
    }
}
