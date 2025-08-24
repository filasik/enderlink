<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('title')->get();
        return Inertia::render('setup/Pages', [
            'pages' => $pages,
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Page::class);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:255',
        ]);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        $data['is_published'] = $data['is_published'] ?? false;
        $data['content'] = app('markdown')->convert($data['content'] ?? '')->getContent();
        $data['content'] = app('html.purifier')->purify($data['content']);
        Page::create($data);
        return redirect()->back()->with('success', 'Page created');
    }

    public function update(Request $request, Page $page)
    {
        Gate::authorize('update', $page);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:255',
        ]);
        $data['is_published'] = $data['is_published'] ?? false;
        $data['content'] = app('markdown')->convert($data['content'] ?? '')->getContent();
        $data['content'] = app('html.purifier')->purify($data['content']);
        $page->update($data);
        return redirect()->back()->with('success', 'Page updated');
    }

    public function destroy(Page $page)
    {
        Gate::authorize('delete', $page);
        $page->delete();
        return redirect()->back()->with('success', 'Page deleted');
    }

    public function show(Page $page)
    {
        if (! $page->is_published) {
            abort(404);
        }
        // Provide list of published pages for nav
        $pages = Page::where('is_published', true)->orderBy('title')->get(['title','slug']);
        return Inertia::render('PageShow', [
            'page' => $page->only(['title','slug','content','meta_description']),
            'pages' => $pages,
        ]);
    }
}
