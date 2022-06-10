<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use \Illuminate\Database\Eloquent\Casts\Attribute;

class GermanDismantler extends Model
{
    use HasFactory;

    protected $table = 'german_dismantlers';

    protected $fillable = [
        'hsn',
        'tsn',
        'manufacturer_plaintext',
        'make',
        'commercial_name',
        'date_of_allotment_of_type_code_number',
        'vehicle_category',
        'code_for_bodywork',
        'code_for_the_fuel_or_power_source',
        'max_net_power_in_kw',
        'engine_capacity_in_cm',
        'max_number_of_axles',
        'max_number_of_powered_axles',
        'max_number_of_seats',
        'technically_permissible_maximum_mass_in_kg',
    ];

  public function ditoNumbers()
  {
      return $this->belongsToMany(DitoNumber::class);
  }

  public function dateOfAllotmentOfTypeCodeNumber (): Attribute
  {
    return Attribute::make(
        set: fn ($value) => Carbon::parse($value),
    );
  }
}
