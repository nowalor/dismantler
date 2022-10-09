<?php

namespace App\Models;

use App\Models\Scopes\DismantleCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DismantleCompany extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new DismantleCompanyScope());
    }
}
