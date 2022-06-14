<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineTypeGermanDismantler extends Model
{
    use HasFactory;

    protected $table = 'engine_type_german_dismantler';

    public $timestamps = false;

    protected $fillable = ['engine_type_id', 'german_dismantler_id'];
}
