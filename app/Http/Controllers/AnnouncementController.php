<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->get();

        return Inertia::render('setup/Announcements', [
            'announcements' => $announcements,
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Announcement::class);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'visibility' => 'required|in:public,private,both',
            'is_pinned' => 'boolean',
            'published_at' => 'nullable|date',
        ]);
        $data['is_pinned'] = $data['is_pinned'] ?? false;
        $data['body'] = app('markdown')->convert($data['body'])->getContent();
        $data['body'] = app('html.purifier')->purify($data['body']);
        Announcement::create($data);

        return redirect()->back()->with('success', 'Announcement created');
    }

    public function update(Request $request, Announcement $announcement)
    {
        Gate::authorize('update', $announcement);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'visibility' => 'required|in:public,private,both',
            'is_pinned' => 'boolean',
            'published_at' => 'nullable|date',
        ]);
        $data['is_pinned'] = $data['is_pinned'] ?? false;
        $data['body'] = app('markdown')->convert($data['body'])->getContent();
        $data['body'] = app('html.purifier')->purify($data['body']);
        $announcement->update($data);
        return redirect()->back()->with('success', 'Announcement updated');
    }

    public function destroy(Announcement $announcement)
    {
        Gate::authorize('delete', $announcement);
        $announcement->delete();
        return redirect()->back()->with('success', 'Announcement deleted');
    }
}
