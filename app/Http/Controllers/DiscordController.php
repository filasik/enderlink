<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Support\Facades\Http;

class DiscordController
{
    public function widget()
    {
        $guildId = Settings::where('key','discord_guild_id')->value('value');
        if (! $guildId) {
            return response()->json(['enabled' => false]);
        }
        try {
            $resp = Http::timeout(5)->get("https://discord.com/api/guilds/{$guildId}/widget.json");
            if ($resp->successful()) {
                return response()->json([
                    'enabled' => true,
                    'data' => $resp->json(),
                ]);
            }
        } catch (\Throwable $e) {
            // swallow
        }
        return response()->json(['enabled' => false]);
    }
}
