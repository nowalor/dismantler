<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SbrCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function ditoNumbers(): BelongsToMany
    {
        return $this->belongsToMany(DitoNumber::class);
    }
}
