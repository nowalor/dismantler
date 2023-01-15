<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class FaqPageController extends Controller
{
    public function __invoke()// : View
    {
        $questions = Faq::all()->groupBy('question_category');

        $questionCategories = Faq::CATEGORIES;

        return view('faq.index', compact('questionCategories', 'questions'));
    }
}
