<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class FaqPageController extends Controller
{
    public function __invoke(): View
    {
        $faqs = Faq::all();

        return view('faq.index', compact('faqs'));
    }
}
