<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EngineType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'connection_completed_at'];

    public function germanDismantlers()
    {
        return $this->belongsToMany(GermanDismantler::class);
    }

    public function carParts(): HasMany
    {
        return $this->hasMany(CarPart::class);
    }
}
