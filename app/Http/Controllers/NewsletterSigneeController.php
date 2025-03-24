<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSignupRequest;
use App\Models\NewsletterSignee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsletterSigneeController extends Controller
{
    public function index(): View
    {
        return view('newsletter.index');
    }

    public function store(NewsletterSignupRequest $request): RedirectResponse
    {
        // including the recaptcha_token, but database doesn't have a recaptcha_token column
        $validated = $request->validated();

        // only including name and email before saving
        $data = collect($validated)->only(['name', 'email'])->toArray();

        NewsLetterSignee::create($data);

        return back()->with('success', 'Thanks for signing up!');
    }
}
