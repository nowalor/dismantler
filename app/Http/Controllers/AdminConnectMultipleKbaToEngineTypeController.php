<?php

namespace App\Http\Controllers;

use App\Models\EngineType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminConnectMultipleKbaToEngineTypeController extends Controller
{
    public function __invoke(EngineType $engineType, Request $request): RedirectResponse
    {
        if (empty($request->get('kba_checkbox'))) {
            return redirect()->back()->with('error', 'No KBA selected');
        }

        $engineType->germanDismantlers()->syncWithoutDetaching($request->get('kba_checkbox'));

        return redirect()->back()->with('connection-saved', 'Kbas have been connected successfully');
    }
}
