<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'car_part_id',
        'reservation_id',
        'is_active',
        'uuid',
    ];

    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public function carPart(): BelongsTo
    {
        return $this->belongsTo(NewCarPart::class);
    }
}
