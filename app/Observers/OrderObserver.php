<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\PaymentSuccessfulNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class OrderObserver
{
    public function created(Order $order): void
    {
        //Notification::route('mail',[])->notify(new PaymentSuccessfulNotification($order)); // TODO
    }
}
