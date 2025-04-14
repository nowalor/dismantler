<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show(Blog $blog): View
    {
        return view('admin.blogs.show', compact('blog'));
    }
}
