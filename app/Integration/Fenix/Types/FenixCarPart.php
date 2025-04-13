<?php

namespace App\Integration\Fenix\Types;

class FenixCarPart
{
    public ?int $original_id = null;
    public ?string $sbr_part_code = null;
    public ?string $sbr_car_code = null;
    public ?string $sbr_car_name = null;
    public ?string $original_number = null;
    public ?float $price_sek = null;
    public ?string $quality = null;
    public ?string $engine_code = null;
    public ?string $engine_type = null;
    public ?string $dismantle_company_name = null;
    public ?string $warranty = null;
    public ?string $article_nr_at_dismantler = null;
    public ?string $body_name = null;
    public ?string $vin = null;
    public ?string $fuel = null;
    public ?string $gearbox = null;
    public ?string $mileage_km = null;
    public ?string $mileage = null;
    public ?string $model_year = null;
    public ?string $dismantled_at = null;
    public ?string $originally_created_at = null;


    public static function fromData(array $data): self
    {
        $carPart = new self;

        $carPart->original_id = $data['Id'] ?? null;
        $carPart->sbr_part_code = $data['SbrPartCode'] ?? null;
        $carPart->sbr_car_code = $data['SbrCarCode'] ?? null;

        $carPart->original_number = $data['OriginalNumber'] ?? null;
        $carPart->price_sek = isset($data['Price']) ? (float) $data['Price'] : null;
        $carPart->quality = $data['Quality'] ?? null;
        $carPart->warranty = $data['Warranty'] ?? null;
        $carPart->dismantled_at = $data['DismantlingDate'] ?? null;
        $carPart->dismantle_company_name = $data['CarBreaker'] ?? null;
        $carPart->article_nr_at_dismantler = $data['ArticleNumberAtCarbreaker'] ?? null;
        $carPart->originally_created_at = $data['CreatedDate'] ?? null;

        $car = $data['Car'] ?? [];

        $carPart->sbr_car_name = $car['SbrCarName'] ?? null;
        $carPart->engine_code = $car['EngineCode1'] ?? null;
        $carPart->engine_type = $car['EngineType'] ?? null;
        $carPart->body_name = $car['BodyName'] ?? null;
        $carPart->vin = $car['VIN'] ?? null;
        $carPart->fuel = $car['Fuel'] ?? null;
        $carPart->gearbox = $car['Gearbox'] ?? null;
        $carPart->model_year = $car['ModelYear'] ?? null;
        $carPart->mileage = isset($car['Mileage']) ? (string) (int) $car['Mileage'] : null;
        $carPart->mileage_km = isset($car['Mileage']) ? (string) ((int) $car['Mileage'] * 10) : null;
        return $carPart;
    }
}
