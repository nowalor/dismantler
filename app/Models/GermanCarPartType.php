<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GermanCarPartType extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    public function carPartTypes(): BelongsToMany
    {
        return $this->belongsToMany(CarPartType::class);
    }
}
