<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    public $timestamps = false;

    const CATEGORY_DELIVERY = 'delivery';
    const CATEGORY_PAYMENT = 'payment';
    const CATEGORY_RETURN = 'return';
    const CATEGORIES = [
        self::CATEGORY_DELIVERY,
        self::CATEGORY_PAYMENT,
        self::CATEGORY_RETURN,
    ];
}
