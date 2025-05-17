<?php

namespace App\Http\Controllers;

use App\Helpers\Constants\SellerPlatform;
use App\Http\Requests\PayRequest;
use App\Models\NewCarPart;
use App\Models\PaymentPlatform;
use App\Resolvers\PaymentPlatformResolver;
use App\Services\SlackNotificationService;
use Illuminate\View\View;

class PaymentController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function index(NewCarPart $carPart)//: View
    {
        $paymentPlatforms = PaymentPlatform::all();

        $checkoutBreadcrumbs = $carPart->prepareCheckoutBreadcrumbs();

        return view('checkout.index', compact(
            'carPart',
            'paymentPlatforms',
            'checkoutBreadcrumbs',
        ));
    }

    public function pay(PayRequest $request, NewCarPart $carPart)
    {

         $validated = $request->validated();


         $validated = array_merge($validated, [
             'value' => $carPart->full_price,
             'new_car_part_id' => $carPart->id,
             'dismantle_company_id' => 1,
             'payment_platform_id' => $request->get('payment_platform'),
             'buyer_name' => $request->get('name'),
             'buyer_email' => $request->get('email'),
             'quantity' => 1,
             'part_price' => $carPart->full_price,
             'city' => $request->get('town'),
         ]);


         $order = $carPart->order()->create($validated);

         $carPart->sold_at = now();
         $carPart->sold_on_platform = SellerPlatform::CURRUS_CONNECT;
         $carPart->save();

         $paymentPlatform = $this->paymentPlatformResolver
             ->resolveService($request->get('payment_platform'));


        session()->put('paymentPlatformId', $request->get('payment_platform'));


        // Just testing out the notification service... will probably move this code elsewhere
       (new SlackNotificationService())->notifyOrderSuccessWebsite(
           $carPart,
       );

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
