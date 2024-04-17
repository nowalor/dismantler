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
        'is_placeholder',
        'new_logo_german',
        'new_logo_danish',
        'new_logo_english',
    ];

    public $timestamps = false;

    public function carPart(): BelongsTo
    {
        return $this->belongsTo(NewCarPart::class, 'new_car_part_id');
    }

    public function logoGerman(): string
    {
        return "https://currus-connect.fra1.digitaloceanspaces.com/img/car-part/{$this->new_car_part_id}/german-logo/{$this->new_logo_german}";
    }
}
