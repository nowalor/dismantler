<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function germanDismantlers(): BelongsToMany
    {
        return $this->belongsToMany(GermanDismantler::class);
    }
}
