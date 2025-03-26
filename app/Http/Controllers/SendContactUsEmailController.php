<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendContactUsEmailRequest;
use App\Mail\ContactUsMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class SendContactUsEmailController extends Controller
{
    public function __invoke(SendContactUsEmailRequest $request)//: RedirectResponse
    {

        $validated = $request->validated();

        try {
            Mail::to('service@currus-connect.com')
                ->send(new ContactUsMail($validated));

            return redirect()->back()->withMessage('Email has been sent successfully');
        } catch (\Exception $e) {
            logger($e->getMessage());

            return redirect()->back()->withError('Something went wrong, you can just write to us at service@currus-connect.com');
        }
    }
}
