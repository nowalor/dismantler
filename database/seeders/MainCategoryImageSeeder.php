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
                'name' => 'Body parts',
            ],
            [
                // fuel system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/tank.png',
                'name' => 'Fuel system',
            ],
            [
                // audio/communication system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/audio-system.png',
                'name' => 'Audio/communication system',
            ],
            [
                // brake system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/break.png',
                'name' => 'Brake system',
            ],
            [
                // gearbox/transmission
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/gearkasse.png',
                'name' => 'Gearbox/transmission',
            ],
            [
                // chassis/steering
                'image' => '',
                'name' => 'Chassis/steering',
            ],
            [
                // cooling/heating/aircon
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/air-conditioner.png',
                'name' => 'Cooling/heating/aircon',
            ],
            [
                // switches/relays/sensor
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/switch.png',
                'name' => 'Switches/relays/sensor',
            ],
            [
                // looks/locking system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/look.png',
                'name' => 'Looks/locking system',
            ],
            [
                // wipers
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/wiper.png',
                'name' => 'Wipers',
            ],
            [
                // interior
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/interior.png',
                'name' => 'Interior',
            ],
            [
                // electronic parts
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/electronic-parts.png',
                'name' => 'Electronic parts',
            ],
            [
                // lights/mirrors
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/lights-mirrors.png',
                'name' => 'Lights/mirrors',
            ],
            [
                // engine/engine parts
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/car-engine.png',
                'name' => 'Engine/engine parts',
            ],
            [
                // exhaust system
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/exhaust-system.png',
                'name' => 'Exhaust system',
            ],
            [
                // instruments
                'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/main-category-images/instruments.png',
                'name' => 'Instruments',
            ]
        ];

        foreach ($mainCategoryImages as $image) {
            DB::table('main_categories')
                ->where('name', $image['name'])
                ->update(['image' => $image['image']]);
        }
    }
}
