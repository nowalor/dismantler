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
            ['name' => 'ALFA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/alfa-romeo.png'],
            ['name' => 'AUDI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/audi.png'],
            ['name' => 'LANCIA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/lancia.png'],
            ['name' => 'MINI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/mini.png'],
            ['name' => 'BMW', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/bmw.png'],
            ['name' => 'CADILLAC', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/cadillac.png'],
            ['name' => 'CITROEN', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/citroen.png'],
            ['name' => 'AMC', 'image' => ''],
            ['name' => 'CHEVROLET', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/chevrolet.png'],
            ['name' => 'DACIA', 'image' => ''],
            ['name' => 'POINTIAC', 'image' => ''],
            ['name' => 'HUMMER', 'image' => ''],
            ['name' => 'CHRYSLER', 'image' => ''],
            ['name' => 'DAEWOO', 'image' => ''],
            ['name' => 'NISSAN', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/nissan.png'],
            ['name' => 'INFINITI', 'image' => ''],
            ['name' => 'DODGE', 'image' => ''],
            ['name' => 'ERBROE', 'image' => ''],
            ['name' => 'FIAT', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/fiat.png'],
            ['name' => 'SEAT', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/seat.png'],
            ['name' => 'IVECO', 'image' => ''],
            ['name' => 'KIA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/kia.png'],
            ['name' => 'FORD', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/ford.png'],
            ['name'  => 'FORD MPV', 'image' => ''],
            ['name'  =>'HONDA', 'image' => ''],
            ['name' => 'ISUZU', 'image' => ''],
            ['name' => 'HYUNDAI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/hyundai.png'],
            ['name' => 'HANOMAG', 'image' => ''],
            ['name' => 'JAGUAR', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/jaguar.png'],
            ['name' => 'LADA', 'image' => ''],
            ['name' => 'MAZDA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/mazda.png'],
            ['name' => 'MERCEDES', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/mercedes-benz.png'],
            ['name' => 'MITSUBISHI', 'image' => ''],
            ['name' => 'MG', 'image' => ''],
            ['name' => 'ROVER', 'image' => ''],
            ['name' => 'BLMC', 'image' => ''],
            ['name' => 'LOTUS', 'image' => ''],
            ['name' => 'ELBILER', 'image' => ''],
            ['name' => 'OLSMOBILE', 'image' => ''],
            ['name' => 'OPEL', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/opel.png'],
            ['name' => 'PEUGEOT', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/peugeot.png'],
            ['name' => 'PORSCHE', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/porsche.png'],
            ['name' => 'RENAULT', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/renault.png'],
            ['name' => 'ROLLS', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/rolls-royce.png'],
            ['name' => 'RANGE', 'image' => ''],
            ['name' => 'SAAB', 'image' => ''],
            ['name' => 'SCANIA', 'image' => ''],
            ['name' => 'SUBARU', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/subaru.png'],
            ['name' => 'SUZUKI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/suzuki.png'],
            ['name' => 'SMART', 'image' => ''],
            ['name' => 'SSANG', 'image' => ''],
            ['name' => 'SKODA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/skoda.png'],
            ['name' => 'TRIUMPH', 'image' => ''],
            ['name' => 'TOYOTA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/toyota.png'],
            ['name' => 'VOLVO', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/volvo.png'],
            ['name' => 'VW', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/volkswagen.png'],
            ['name' => 'MAN', 'image' => ''],
            ['name' => 'LDV', 'image' => ''],
            ['name' => 'DAIHATSU', 'image' => ''],
            ['name' => 'ASTON', 'image' => ''],
            ['name' => 'TESLA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/tesla.png'],
            ['name' => 'FERARRI', 'image' => ''],
            ['name' => 'LAMBORGHINI', 'image' => ''],
            ['name' => 'MASERATI', 'image' => ''],
            ['name' => 'MAXUS', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/maserati.png'],
            ['name' => 'AIWAYS', 'image' => ''],
            ['name' => 'POLESTAR', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/polestar.png'],
        ];

        //CarBrand::insert($brands);
        foreach ($brands as $brand) {
            CarBrand::updateOrCreate(
                ['name' => $brand['name']], // Condition to find existing record
                ['image' => $brand['image']] // Data to update or create
            );
        }
    }
}
