<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PublicBlogArticleController extends Controller
{
    public function show(Blog $blog): View
    {
        // use same blade for both admin and user
        return view('admin.blogs.show', compact('blog'));
    }
}
