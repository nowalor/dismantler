<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        // Only filter if search is present and not empty
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('content', 'LIKE', "%{$search}%")
                ->orWhere('tags', 'LIKE', "%{$search}%");
        }

        $blogs = $query->latest()->paginate(2);
        return view('admin.blogs.index', compact('blogs'));
    }


    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'published_at' => 'required|date',
            'tags' => 'nullable|string',
        ]);

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => Carbon::parse($request->published_at),
            'tags' => json_encode(explode(',', $request->tags)),
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'published_at' => 'required|date',
            'tags' => 'nullable|string',
        ]);

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => Carbon::parse($request->published_at),
            'tags' => json_encode(explode(',', $request->tags)),
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
