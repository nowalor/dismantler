<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_part_id',
        'reservation_id',
        'is_active',
    ];

    public function carPart(): BelongsTo
    {
        return $this->belongsTo(NewCarPart::class);
    }
}
