<?php

namespace Database\Seeders;

use App\Models\DismantleCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DismantleCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DismantleCompany::insert([
            ["id" => 43, "name" => "AABEN", "full_name" => "DKAUTO.DK"],
            ["id" => 44, "name" => "AADUM", "full_name" => "Aadum Autoophug A/S"],
            ["id" => 45, "name" => "AUHOB", "full_name" => "HOBRO AUTOGENBRUG APS"],
            ["id" => 47, "name" => "BRAMM", "full_name" => "BRAMMING AUTO-LAGER APS"],
            [
                "id" => 48,
                "name" => "BROND",
                "full_name" => "BRØNDERSLEV  AUTOGENBRUG  A/S",
            ],
            ["id" => 50, "name" => "DANSK", "full_name" => "DANSK-TYSK AUTOLAGER "],
            ["id" => 53, "name" => "GEDHUG", "full_name" => "GEDSTED AUTO-OPHUG A/S"],
            ["id" => 55, "name" => "HALLI", "full_name" => "HALLING AUTOOPHUG APS"],
            ["id" => 57, "name" => "HENNE", "full_name" => "HENNE AUTO LAGER APS"],
            ["id" => 61, "name" => "HOLST", "full_name" => "HOLSTEBRO AUTOGENBRUG APS"],
            ["id" => 66, "name" => "NJYSK", "full_name" => "Nordjysk Autoophug A/S"],
            [
                "id" => 68,
                "name" => "RAVNS",
                "full_name" => "LEIF RAVNSKJÆR AUTOGENBRUG",
            ],
            ["id" => 70, "name" => "RODDI", "full_name" => "RØDDING AUTOGENBRUG APS"],
            ["id" => 71, "name" => "SCHMI", "full_name" => "Schmiedmann"],
            ["id" => 74, "name" => "SKAND", "full_name" => "BØRGES AUTOOPHUG APS"],
            ["id" => 75, "name" => "SLAGE", "full_name" => "Slagelse Autoophug ApS"],
            ["id" => 77, "name" => "SUNTY", "full_name" => "SUNDBY THY AUTOOPHUG APS"],
            ["id" => 78, "name" => "SYFYN", "full_name" => "Autogenbrug Svendborg"],
            ["id" => 82, "name" => "VOJEN", "full_name" => "VOJENS AUTOOPHUG APS"],
            [
                "id" => 94,
                "name" => "SCHOBER",
                "full_name" => "Brdr. Schøber Autoimport ApS",
            ],
            ["id" => 95, "name" => "GEDHAN", "full_name" => "Gedsted Autohandel A/S"],
            ["id" => 96, "name" => "HOBGT", "full_name" => "Hobro Gearteknik"],
            ["id" => 97, "name" => "SJAEL", "full_name" => "Sjællands Autoophug"],
        ]);
    }
}
