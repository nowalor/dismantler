<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        return $this->searchBlogs($request);
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        // Validate request
        $this->validateBlogRequest($request);

        // Handle image upload (null means no old image to delete)
        $imagePath = $this->handleImageUpload($request, null);

        // Create the blog record
        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'image' => $imagePath,
        ]);

        // Handle tags
        $this->handleTags($request, $blog);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $blog->load('tags');
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        // Validate request
        $this->validateBlogRequest($request);

        // Handle image upload (pass existing image for potential deletion)
        $imagePath = $this->handleImageUpload($request, $blog->image);

        // Update the blog record
        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'image' => $imagePath,
        ]);

        // Handle tags
        $this->handleTags($request, $blog);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully.');
    }


    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            // Parse out the path (e.g. "/img/blog-image/xxxx.jpg")
            $path = parse_url($blog->image, PHP_URL_PATH);
            // Remove leading slash => "img/blog-image/xxxx.jpg"
            $path = ltrim($path, '/');

            Storage::disk('do')->delete($path);
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    public function filterByTag(Request $request, $tagName)
    {
        return $this->searchBlogs($request, $tagName);
    }

    public function searchBlogs(Request $request, $tagName = null)
    {
        if ($tagName) {
            $tag = Tag::where('name', $tagName)->firstOrFail();
            $query = $tag->blogs()->latest();
            $viewName = 'admin.blogs.filtered-blogs';
        } else {
            $query = Blog::latest();
            $viewName = 'admin.blogs.index';
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%")
                    ->orWhereHas('tags', function ($tagQuery) use ($search) {
                        $tagQuery->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $blogs = $query->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'html' => view($viewName, compact('blogs', 'tagName'))->render(),
            ]);
        }

        return view($viewName, compact('blogs', 'tagName'));
    }


    private function validateBlogRequest(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'published_at' => 'required|date',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }

    private function handleImageUpload(Request $request, ?string $currentImage = null): ?string
    {
        if (!$request->hasFile('image')) {
            // No new image uploaded; just return the old path
            return $currentImage;
        }

        // If there's an old image, delete it
        if ($currentImage) {
            $oldRelativePath = str_replace(rtrim(env('DO_CDN_ENDPOINT'), '/') . '/', '', $currentImage);
            Storage::disk('do')->delete($oldRelativePath);
        }

        $file = $request->file('image');
        $imageName = time() . '_' . $file->getClientOriginalName();
        $folder = 'img/blog-image';
        $filePath = $folder . '/' . $imageName;

        // Upload to DigitalOcean Spaces
        Storage::disk('do')->put($filePath, file_get_contents($file), [
            'visibility' => 'public',
            'ACL' => 'public-read',
            'ContentType' => $file->getMimeType(),
        ]);

        // Return the full CDN URL
        $cdnUrl = rtrim(env('DO_CDN_ENDPOINT'), '/');
        return $cdnUrl . '/' . $filePath;
    }

    private function handleTags(Request $request, Blog $blog): void
    {
        if ($request->filled('tags')) {
            $blog->syncTags($request->tags);
        } else {
            $blog->tags()->detach();
        }
    }
}
