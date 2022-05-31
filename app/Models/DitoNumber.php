<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DitoNumber extends Model
{
    use HasFactory;

    protected $fillable = [
      'producer',
      'brand',
      'production_date',
      'dito_number',
    ];

    public function germanDismantler()
    {
        return $this->belongsToMany(GermanDismantler::class);
    }
}
