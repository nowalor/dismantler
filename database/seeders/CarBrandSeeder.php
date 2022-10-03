<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['name' => 'ALFA'],
            ['name' => 'AUDI'],
            ['name' => 'LANCIA'],
            ['name' => 'MINI'],
            ['name' => 'BMW'],
            ['name' => 'CADILLAC'],
            ['name' => 'CITROEN'],
            ['name' => 'AMC'],
            ['name' => 'CHEVROLET'],
            ['name' => 'DACIA'],
            ['name' => 'POINTIAC'],
            ['name' => 'HUMMER'],
            ['name' => 'CHRYSLER'],
            ['name' => 'DAEWOO'],
            ['name' => 'NISSAN'],
            ['name' => 'INFINITI'],
            ['name' => 'DODGE'],
            ['name' => 'ERBROE'],
            ['name' => 'FIAT'],
            ['name' => 'SEAT'],
            ['name' => 'IVECO'],
            ['name' => 'KIA'],
            ['name' => 'FORD'],
            ['name'  => 'FORD MPV'],
            ['name'  =>'HONDA'],
            ['name' => 'ISUZU'],
            ['name' => 'HYUNDAI'],
            ['name' => 'HANOMAG'],
            ['name' => 'JAGUAR'],
            ['name' => 'LADA'],
            ['name' => 'MAZDA'],
            ['name' => 'MERCEDES'],
            ['name' => 'MITSUBISHI'],
            ['name' => 'MG'],
            ['name' => 'ROVER'],
            ['name' => 'BLMC'],
            ['name' => 'LOTUS'],
            ['name' => 'ELBILER'],
            ['name' => 'OLSMOBILE'],
            ['name' => 'OPEL'],
            ['name' => 'PEUGEOT'],
            ['name' => 'PORSCHE'],
            ['name' => 'RENAULT'],
            ['name' => 'ROLLS'],
            ['name' => 'RANGE'],
            ['name' => 'SAAB'],
            ['name' => 'SCANIA'],
            ['name' => 'SUBARU'],
            ['name' => 'SUZUKI'],
            ['name' => 'SMART'],
            ['name' => 'SSANG'],
            ['name' => 'SKODA'],
            ['name' => 'TRIUMPH'],
            ['name' => 'TOYOTA'],
            ['name' => 'VOLVO'],
            ['name' => 'VW'],
            ['name' => 'MAN'],
            ['name' => 'LDV'],
            ['name' => 'DAIHATSU'],
            ['name' => 'ASTON'],
            ['name' => 'TESLA'],
            ['name' => 'FERARRI'],
            ['name' => 'LAMBORGHINI'],
            ['name' => 'MASERATI'],
            ['name' => 'MAXUS'],
            ['name' => 'AIWAYS'],
            ['name' => 'POLESTAR'],
        ];

        CarBrand::insert($brands);
    }
}
