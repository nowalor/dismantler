<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewCarPartImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_url',
        'image_name',
        'new_car_part_id',
        'image_name_blank_logo',
        'priority',
    ];

    public $timestamps = false;

    public function carPart(): BelongsTo
    {
        return $this->belongsTo(NewCarPart::class, 'new_car_part_id');
    }
}
