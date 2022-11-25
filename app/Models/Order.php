<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'car_part_id',
        'dismantle_company_id',
        'payment_platform_id',
        'currency_id',
        'quantity',
        'part_price',
        'is_part_delivered',
        'buyer_name',
        'buyer_email',
        'quantity',
        'city',
        'zip_code',
        'address',
        'payment_provider_id',
    ];
}
