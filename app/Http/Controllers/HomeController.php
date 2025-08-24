<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Settings;
use App\Models\Page;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class HomeController
{
    public function __invoke()
    {
        $now = now();
        $announcements = Announcement::where(function($q){
                $q->where('visibility','public')->orWhere('visibility','both');
            })
            ->where(function($q) use ($now){
                $q->whereNull('published_at')->orWhere('published_at','<=',$now);
            })
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->limit(5)
            ->get(['id','title','body','is_pinned','published_at']);

    $pages = Page::where('is_published', true)->orderBy('title')->get(['title','slug']);
    $discordGuildId = Settings::where('key','discord_guild_id')->value('value');
        $discordWidgetEnabled = Settings::where('key','discord_widget_enabled')->value('value') === 'true';

    return Inertia::render('Home', [
            'public_announcements' => $announcements,
            'pages' => $pages,
            'discord' => [
                'guild_id' => $discordGuildId,
                'widget_enabled' => $discordWidgetEnabled,
            ],
        ]);
    }
}
