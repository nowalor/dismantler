<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendContactUsEmailController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        Mail::to('nikulasoskarsson@gmail.com')
            ->send(new ContactUsMail($request->all()));

        return redirect()->back()->withMessage('Email has been sent successfully');
    }
}
