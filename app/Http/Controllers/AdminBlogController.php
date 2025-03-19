<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Actions\UploadBlogImageAction;

class AdminBlogController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        return $this->searchBlogs($request);
    }

    public function create(): View
    {
        return view('admin.blogs.create');
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $blogData = $request->validated();

        if ($request->hasFile('image')) {
            $blogData['image'] = app(UploadBlogImageAction::class)->execute(
                $request->file('image')
            );
        }

        $blog = Blog::create($blogData);

        $this->handleTags($request, $blog);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog): View
    {
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog): View
    {
        $blog->load('tags');
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        $blogData = $request->validated();

        if ($request->hasFile('image')) {
            $blogData['image'] = app(UploadBlogImageAction::class)->execute(
                $request->file('image'),
                $blog->image
            );
        }

        $blog->update($blogData);

        $this->handleTags($request, $blog);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        if ($blog->image) {
            app(UploadBlogImageAction::class)->delete($blog->image);
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    public function filterByTag(Request $request, string $tagName): View|JsonResponse
    {
        return $this->searchBlogs($request, $tagName);
    }

    public function searchBlogs(Request $request, ?string $tagName = null): View|JsonResponse
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

    private function handleTags(Request $request, Blog $blog): void
    {
        if ($request->filled('tags')) {
            $blog->syncTags($request->input('tags'));
        } else {
            $blog->tags()->detach();
        }
    }
}
