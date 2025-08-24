<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Announcement;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $votingSites = \App\Models\VotingSite::orderBy('sort_order')->get(['id','name','url_template','pass_username','enabled','sort_order']);
    $now = now();
    $announcements = Announcement::where(function($q){
            $q->where('visibility','private')->orWhere('visibility','both');
        })
        ->where(function($q) use ($now){
            $q->whereNull('published_at')->orWhere('published_at','<=',$now);
        })
        ->orderByDesc('is_pinned')
        ->orderByDesc('published_at')
        ->limit(10)
        ->get(['id','title','body','is_pinned','published_at']);

    $pages = Page::orderBy('title')->get(['title','slug','is_published']);
    $discordGuildId = Settings::where('key','discord_guild_id')->value('value');
    $discordWidgetEnabled = Settings::where('key','discord_widget_enabled')->value('value') === 'true';

    return Inertia::render('Dashboard', [
            // Server status / IP
            'status_enabled' => Settings::where('key', 'status_enabled')->value('value') === 'true',
            'status_query_ip' => Settings::where('key', 'status_query_ip')->value('value') ?? '',
            'status_query_port' => Settings::where('key', 'status_query_port')->value('value') ?? '',

            // Links
            'links_enabled' => Settings::where('key', 'links_enabled')->value('value') === 'true',
            'discord_link' => Settings::where('key', 'discord_link')->value('value') ?? '',
            'instagram_link' => Settings::where('key', 'instagram_link')->value('value') ?? '',
            'tiktok_link' => Settings::where('key', 'tiktok_link')->value('value') ?? '',
            'youtube_link' => Settings::where('key', 'youtube_link')->value('value') ?? '',
            'voting_sites' => $votingSites,
            'private_announcements' => $announcements,
            'pages' => $pages,
            'discord' => [
                'guild_id' => $discordGuildId,
                'widget_enabled' => $discordWidgetEnabled,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
