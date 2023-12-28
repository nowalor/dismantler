<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    public $timestamps = FALSE;

    protected $fillable = ['car_brand_id', 'name', 'sbr_code_id', ];
}
