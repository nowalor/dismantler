<?php

namespace App\Resolvers;

use App\Models\PaymentPlatform;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PaymentPlatformResolver
{
    protected $paymentPlatforms;

    public function __construct()
    {
        $this->paymentPlatforms = Cache::rememberForever('payment_platforms', function () {
            return PaymentPlatform::all();
        });
    }

    public function resolveService($paymentPlatformId)
    {
        $name = strtolower(
            $this->paymentPlatforms
                ->firstWhere('id', $paymentPlatformId)
                ->name
        );
        Log::info('--- NAME ---');

        Log::info($name);
        $service = config("services.$name.class");

        if(empty($service)) {
            return throw New \Exception('Not in config', 500);
        }

        return resolve($service);
    }
}
