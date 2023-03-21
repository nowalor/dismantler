<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\DitoNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ManufacturerText;

class ManufacturerPlaintextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = DitoNumber::select(['brand', 'car_brand_id'])->get();

        foreach($models as $model) {
            CarModel::create([
               'name' => $model->brand,
               'car_brand_id' =>  $model->car_brand_id,
            ]);
        }
    }
}
