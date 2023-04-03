<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DitoNumberGermanDismantler extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $table = 'dito_number_german_dismantler';

    protected $fillable = ['dito_number_id', 'german_dismantler_id'];
}
