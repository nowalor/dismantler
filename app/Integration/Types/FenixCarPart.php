<?php

namespace App\Integration\Types;

class FenixCarPart
{
    public ?int $id = null;
    public ?string $sbr_part_code = null;
    public ?string $original_number = null;
    public ?float $price_sek = null;
    public ?string $quality = null;
    public ?string $engine_code = null;
    public ?string $engine_type = null;
    public ?string $dismantle_company_name = null;
    public ?string $article_nr_at_dismantler = null;
    public ?string $body_name = null;
    public ?string $vin = null;
    public ?string $fuel = null;
    public ?string $gearbox = null;
    public ?string $mileage_km = null;
    public ?string $mileage = null;
    public ?string $model_year = null;
    public ?string $dismantled_at = null;

    public array $images = [];

    public static function fromData(array $data): self
    {
        $carPart = new self;

        $carPart->id = $data['Id'] ?? null;
        $carPart->sbr_part_code = $data['SbrPartCode'] ?? null;
        $carPart->original_number = $data['OriginalNumber'] ?? null;
        $carPart->price_sek = isset($data['Price']) ? (float) $data['Price'] : null;
        $carPart->quality = $data['Quality'] ?? null;
        $carPart->dismantled_at = $data['DismantlingDate'] ?? null;
        $carPart->dismantle_company_name = $data['CarBreaker'] ?? null;
        $carPart->article_nr_at_dismantler = $data['ArticleNumberAtCarbreaker'] ?? null;
        $carPart->images = $data['Images'] ?? [];

        $car = $data['Car'] ?? [];

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
