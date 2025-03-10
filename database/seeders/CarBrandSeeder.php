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
            ['name' => 'DACIA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/dacia.png'],
            ['name' => 'POINTIAC', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/pontiac.png'],
            ['name' => 'HUMMER', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/hummer.png'],
            ['name' => 'CHRYSLER', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/chrysler.png'],
            ['name' => 'DAEWOO', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/daewoo.png'],
            ['name' => 'NISSAN', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/nissan.png'],
            ['name' => 'INFINITI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/infiniti.png'],
            ['name' => 'DODGE', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/dodge.png'],
            ['name' => 'ERBROE', 'image' => ''],
            ['name' => 'FIAT', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/fiat.png'],
            ['name' => 'SEAT', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/seat.png'],
            ['name' => 'IVECO', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/iveco.png'],
            ['name' => 'KIA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/kia.png'],
            ['name' => 'FORD', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/ford.png'],
            ['name'  => 'FORD MPV', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/ford.png'],
            ['name'  =>'HONDA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/honda.png'],
            ['name' => 'ISUZU', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/isuzu.png'],
            ['name' => 'HYUNDAI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/hyundai.png'],
            ['name' => 'HANOMAG', 'image' => ''],
            ['name' => 'JAGUAR', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/jaguar.png'],
            ['name' => 'LADA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/lada.png'],
            ['name' => 'MAZDA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/mazda.png'],
            ['name' => 'MERCEDES', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/mercedes-benz.png'],
            ['name' => 'MITSUBISHI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/mitsubishi.png'],
            ['name' => 'MG', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/mg.png'],
            ['name' => 'ROVER', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/rover.png'],
            ['name' => 'BLMC', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/leyland.png'],
            ['name' => 'LOTUS', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/lotus.png'],
            ['name' => 'ELBILER', 'image' => ''],
            ['name' => 'OLSMOBILE', 'image' => ''],
            ['name' => 'OPEL', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/opel.png'],
            ['name' => 'PEUGEOT', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/peugeot.png'],
            ['name' => 'PORSCHE', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/porsche.png'],
            ['name' => 'RENAULT', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/renault.png'],
            ['name' => 'ROLLS', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/rolls-royce.png'],
            ['name' => 'RANGE', 'image' => ''],
            ['name' => 'SAAB', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/saab.png'],
            ['name' => 'SCANIA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/scania.png'],
            ['name' => 'SUBARU', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/subaru.png'],
            ['name' => 'SUZUKI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/suzuki.png'],
            ['name' => 'SMART', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/smart.png'],
            ['name' => 'SSANG', 'image' => ''],
            ['name' => 'SKODA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/skoda.png'],
            ['name' => 'TRIUMPH', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/triumph.png'],
            ['name' => 'TOYOTA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/toyota.png'],
            ['name' => 'VOLVO', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/volvo.png'],
            ['name' => 'VW', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/volkswagen.png'],
            ['name' => 'MAN', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/man.png'],
            ['name' => 'LDV', 'image' => ''],
            ['name' => 'DAIHATSU', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/daihatsu.png'],
            ['name' => 'ASTON', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/aston-martin.png'],
            ['name' => 'TESLA', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/tesla.png'],
            ['name' => 'FERARRI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/ferrari.png'],
            ['name' => 'LAMBORGHINI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/lamborghini.png'],
            ['name' => 'MASERATI', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/maserati.png'],
            ['name' => 'MAXUS', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/maxus.png'],
            ['name' => 'AIWAYS', 'image' => 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/car-brand-logo/logos/optimized/aiways.png'],
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
