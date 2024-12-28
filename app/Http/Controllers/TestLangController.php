<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestLangController extends Controller
{
    public function __invoke()
    {
        return 'test';
    }
}
