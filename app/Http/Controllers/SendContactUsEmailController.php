<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendContactUsEmailRequest;
use App\Mail\ContactUsMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class SendContactUsEmailController extends Controller
{
    public function __invoke(SendContactUsEmailRequest $request): RedirectResponse
    {
        Mail::to('nikulasoskarsson@gmail.com')
            ->send(new ContactUsMail($request->validated()));

        return redirect()->back()->withMessage('Email has been sent successfully');
    }
}
