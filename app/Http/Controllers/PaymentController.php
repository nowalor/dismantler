<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayRequest;
use App\Models\CarPart;
use App\Models\NewCarPart;
use App\Models\Order;
use App\Models\PaymentPlatform;
use App\Resolvers\PaymentPlatformResolver;
use Illuminate\View\View;

class PaymentController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function index(NewCarPart $carPart): View
    {
        $paymentPlatforms = PaymentPlatform::all();


        return view('checkout.index', compact(
            'carPart',
            'paymentPlatforms',
        ));
    }

    public function pay(PayRequest $request, NewCarPart $carPart)
    {

         $validated = $request->validated();


         $validated = array_merge($validated, [
             'value' => $carPart->price_eur,
             'new_car_part_id' => $carPart->id,
             'dismantle_company_id' => 1,
             'payment_platform_id' => $request->get('payment_platform'),
             'buyer_name' => $request->get('name'),
             'buyer_email' => $request->get('email'),
             'quantity' => 1,
             'part_price' =>123,
             'city' => $request->get('town'),
         ]);


         $order = $carPart->order()->create($validated);

         $paymentPlatform = $this->paymentPlatformResolver
             ->resolveService($request->get('payment_platform'));


        session()->put('paymentPlatformId', $request->get('payment_platform'));


        return $paymentPlatform->handlePayment($validated, $order->id);
    }

    public function approval()
    {
        if(!session()->has('paymentPlatformId')) {
            return redirect()
                ->back()
                ->withErrors('Cannot get payment platform');
        }

        $paymentPlatform = $this->paymentPlatformResolver
            ->resolveService(session()->get('paymentPlatformId'));

        return $paymentPlatform->handleApproval();
    }

    public function cancelled()
    {
        return 'missing cancelled view';
        /*return redirect()
            ->route('home')
            ->withErrors('You canceled the payment.'); */
    }

    public function success()
    {
        return view('checkout.success');
    }
}
