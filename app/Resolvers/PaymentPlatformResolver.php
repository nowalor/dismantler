<?php

namespace App\Resolvers;

use App\Models\PaymentPlatform;

class PaymentPlatformResolver
{
    protected $paymentPlatforms;

    public function __construct()
    {
        $this->paymentPlatforms = PaymentPlatform::all();
    }

    public function resolveService($paymentPlatformId)
    {
        $name = strtolower(
            $this->paymentPlatforms
                ->firstWhere('id', $paymentPlatformId)
                ->name
        );

        $service = config("services.$name.class");

        if(empty($service)) {
            return throw New \Exception('Not in config', 500);
        }

        return resolve($service);
    }
}
