<?php

namespace Database\Seeders;

use App\Models\SbrCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AddProducerDetailsToSbrCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(base_path() . '/database/data/producers-contact-details.json');

        $data = json_decode($file, true);

        foreach($data as $item) {
            SbrCode::where('name', 'like', "%{$item['producer']}%")->update([
                'producer' => $item['producer'],
                'producer_address' => $item['address'],
                'producer_email' => $item['email'],
                'producer_phone' => $item['phone'],
            ]);
        }
    }
}
