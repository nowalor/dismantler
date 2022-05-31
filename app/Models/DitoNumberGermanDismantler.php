<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DitoNumberGermanDismantler extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'dito_number_german_dismantler';

    protected $fillable = ['dito_number_id', 'german_dismantler_id'];
}
