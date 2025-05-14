<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSignee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminNewsletterController extends Controller
{
    public function index(Request $request): View
    {
        $query = NewsletterSignee::query();

        $showAll = $request->has('type') && $request->type === 'all';
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if (!$showAll) {
            $query->whereNull('seen_at');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if (in_array($sortBy, ['id', 'name', 'email', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } elseif ($sortBy === 'status') {
            $query->orderByRaw('ISNULL(seen_at) ' . ($sortOrder === 'asc' ? 'ASC' : 'DESC'));
        }

        $signees = $query->paginate(10)->withQueryString();

        return view('admin.newsletter.index', compact('signees', 'showAll', 'sortBy', 'sortOrder', 'search'));
    }

    public function markAsSeen(): RedirectResponse
    {
        NewsletterSignee::whereNull('seen_at')->update(['seen_at' => now()]);
        return redirect()->back();
    }

    public function destroy(NewsletterSignee $signee): RedirectResponse
    {
        $signee->delete();
        return redirect()->back()->with('success', 'Signee deleted successfully.');
    }
}
