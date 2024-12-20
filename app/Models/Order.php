<?php

namespace App\Models;

use App\Models\Scopes\NewCarPartScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'new_car_part_id',
        'dismantle_company_id',
        'payment_platform_id',
        'currency_id',
        'quantity',
        'part_price',
        'status',
        'buyer_name',
        'buyer_email',
        'quantity',
        'city',
        'zip_code',
        'address',
        'payment_provider_id',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_BEING_DELIVERED = 'being_delivered';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELED = 'canceled';
    const STATUS_REFUNDED = 'refunded';

    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_BEING_DELIVERED,
        self::STATUS_DELIVERED,
        self::STATUS_CANCELED,
        self::STATUS_REFUNDED,
    ];

    const STATUS_LABELS = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_BEING_DELIVERED => 'Being delivered',
        self::STATUS_DELIVERED => 'Delivered',
        self::STATUS_CANCELED => 'Canceled',
        self::STATUS_REFUNDED => 'Refunded',
    ];


    public function carPart(): BelongsTo
    {
        return $this->belongsTo(NewCarPart::class, 'new_car_part_id')
            ->withoutGlobalScope(new NewCarPartScope());
    }

    public function dismantleCompany(): BelongsTo
    {
        return $this->belongsTo(DismantleCompany::class);
    }
}
