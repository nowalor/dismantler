<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewCarPartImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_url',
        'image_name',
        'new_car_part_id',
    ];

    public $timestamps = false;
}
