<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSignee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminNewsletterController extends Controller
{
    public function index(Request $request)//: View
    {
        $query = NewsletterSignee::query();

        $showAll = $request->has('type') && $request->type === 'all';

        if (!$showAll) {
            $query->whereNull('seen_at');
        }
        $signees = $query->get();

        return view('admin.newsletter.index', compact('signees', 'showAll'));
    }

    public function markAsSeen(): RedirectResponse
    {
        NewsletterSignee::whereNull('seen_at')->update(['seen_at' => now()]);

        return redirect()->back();
    }

    public function delete(int $id): RedirectResponse
    {
        $signee = NewsletterSignee::findOrFail($id);
        $signee->delete();

        return redirect()->back()->with('success', 'Signee deleted successfully.');
    }

}
