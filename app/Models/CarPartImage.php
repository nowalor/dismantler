<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarPartImage extends Model
{
    use HasFactory;

    public function CarPart(): BelongsTo
    {
        return $this->belongsTo(CarPart::class);
    }
}
