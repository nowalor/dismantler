<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GermanCarPartType extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    public $timestamps = false;

    public const GERMAN_CAR_PART_TYPE_MOTOR = 'Motor';
    public const GERMAN_CAR_PART_TYPE_VERTEILERGETRIBE = 'Verteilergetriebe';
    public const GERMAN_CAR_PART_TYPE_AUTOMATIKGETRIEBE = 'Automatikgetriebe';
    public const GERMAN_CAR_PART_TYPE_SCHALTGETRIEBE = 'Schaltgetriebe 6-Gang';
    public const GERMAN_CAR_PART_TYPE_PARTIKELFILTER = 'Partikelfilter';
    public const GERMAN_CAR_PART_TYPE_KATALYSATOR = 'Katalysator';
    public const GERMAN_CAR_PART_TYPE_DIFFERENTIAL = 'Differential';

    public const TYPES_IN_DELIVERY_OPTION_ONE = [
        self::GERMAN_CAR_PART_TYPE_MOTOR
    ];

    public const TYPES_IN_DELIVERY_OPTION_TWO = [
        self::GERMAN_CAR_PART_TYPE_VERTEILERGETRIBE,
        self::GERMAN_CAR_PART_TYPE_AUTOMATIKGETRIEBE,
        self::GERMAN_CAR_PART_TYPE_SCHALTGETRIEBE,
    ];

    public const TYPES_IN_DELIVERY_OPTION_THREE = [
        self::GERMAN_CAR_PART_TYPE_PARTIKELFILTER,
        self::GERMAN_CAR_PART_TYPE_KATALYSATOR,
        self::GERMAN_CAR_PART_TYPE_DIFFERENTIAL,
    ];




    protected $fillable = [
        'name',
        'autoteile_markt_id'
    ];

    public function carPartTypes(): BelongsToMany
    {
        return $this->belongsToMany(CarPartType::class);
    }
}
