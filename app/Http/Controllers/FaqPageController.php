<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class FaqPageController extends Controller
{

    public function __invoke(): View
    {
        // Laravel will automatically load the correct language file based on the current locale
        $faqs = trans('faqs.categories');

        // Get the categories (keys of the faqs array)
        $questionCategories = array_keys($faqs);

        return view('faq.index', compact('questionCategories', 'faqs'));
    }

}
