<?php

namespace App\Http\Controllers;

use App\Models\VotingSite;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log; // Removed debug logging
use Inertia\Inertia;

class VotingSiteController extends Controller
{
    public function index()
    {
        $sites = VotingSite::orderBy('sort_order')->get();

        return Inertia::render('voting/Index', [
            'sites' => $sites->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'url_template' => $s->url_template,
                'pass_username' => $s->pass_username,
                'enabled' => $s->enabled,
                'sort_order' => $s->sort_order,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'url_template' => 'required|string|max:255',
            'pass_username' => 'required|boolean',
            'enabled' => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0|max:1000',
        ]);
        // Basic URL validation allowing {username}
        $testUrl = str_replace('{username}', 'testuser', $data['url_template']);
        if (! filter_var($testUrl, FILTER_VALIDATE_URL)) {
            return back()->withErrors(['url_template' => 'The URL template must be a valid URL (you may include {username}).'])->withInput();
        }

    $data['sort_order'] = $data['sort_order'] ?? 0;

    VotingSite::create($data);
    return redirect()->route('tenant.voting.index', ['tenant' => tenant('id')])->with('success', 'Voting site added.');
    }

    public function update(Request $request, VotingSite $votingSite)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'url_template' => 'required|string|max:255',
            'pass_username' => 'required|boolean',
            'enabled' => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0|max:1000',
        ]);
        $testUrl = str_replace('{username}', 'testuser', $data['url_template']);
        if (! filter_var($testUrl, FILTER_VALIDATE_URL)) {
            return back()->withErrors(['url_template' => 'The URL template must be a valid URL (you may include {username}).'])->withInput();
        }
    $data['sort_order'] = $data['sort_order'] ?? 0;

    // Ensure booleans stored correctly even if sent as 1/0 strings
    $data['pass_username'] = (bool) $data['pass_username'];
    $data['enabled'] = (bool) $data['enabled'];
    $votingSite->update($data);

    return redirect()->route('tenant.voting.index', ['tenant' => tenant('id')])->with('success', 'Voting site updated.');
    }

    public function destroy(VotingSite $votingSite)
    {
    $votingSite->delete();
    return redirect()->route('tenant.voting.index', ['tenant' => tenant('id')])->with('success', 'Voting site deleted.');
    }
}
