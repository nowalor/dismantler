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
        $validated = $request->validated();

        NewsLetterSignee::create($validated);

        return back()->with('success', 'Thanks for signing up!');
    }
}
