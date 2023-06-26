<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewCarPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_id',
        'car_part_type_id',
        'internal_dismantle_company_id',
        'external_dismantle_company_id',
        'data_provider_id',
        'name',
        'price',
        'quantity',
        'sbr_part_code',
        'sbr_car_code',
        'original_number',
        'quality',
        'dismantled_at',
        'article_nr',
    ];
}
