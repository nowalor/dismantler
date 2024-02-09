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

    public const GERMAN_CAR_PART_TYPE_INSTRUMENTE_TACHOMETER = 'Instrumente Tachometer';
    public const GERMAN_CAR_PART_TYPE_ABS_BREMSAGGREGAT= 'ABS Bremsaggregat';
    public const GERMAN_CAR_PART_TYPE_ELEKTRIK_STEUEGERAT_AUTOMATIKGETR = 'Elektrik Steuergerät Automatikgetr';
    public const GERMAN_CAR_PART_TYPE_LENKUNG_SERVOLENKUNG_LENKETRIE = 'Lenkung Servolenkung Lenkgetrie';


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

    public const TYPES_IN_DELIVERY_OPTION_FOUR = [
        self::GERMAN_CAR_PART_TYPE_INSTRUMENTE_TACHOMETER,
        self::GERMAN_CAR_PART_TYPE_ABS_BREMSAGGREGAT,
        self::GERMAN_CAR_PART_TYPE_ELEKTRIK_STEUEGERAT_AUTOMATIKGETR,
        self::GERMAN_CAR_PART_TYPE_LENKUNG_SERVOLENKUNG_LENKETRIE,
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
