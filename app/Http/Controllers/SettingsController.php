<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Settings::all()->pluck('value', 'key')->toArray();

        // if value is 'true' or 'false', convert to boolean
        foreach ($settings as $key => $value) {
            if ($value === 'true') {
                $settings[$key] = true;
            } elseif ($value === 'false') {
                $settings[$key] = false;
            }
        }

        return Inertia::render('setup/Index', [
            'settings' => $settings,
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
        $data = $request->only([
            'status_enabled',
            'status_query_ip',
            'status_query_port',
            'app_name',
            'links_enabled',
            'discord_link',
            'discord_guild_id',
            'discord_widget_enabled',
            'instagram_link',
            'tiktok_link',
            'youtube_link',
        ]);

        foreach ($data as $key => $value) {
            Settings::updateOrCreate(
                ['key' => $key],
                ['value' => is_bool($value) ? ($value ? 'true' : 'false') : $value]
            );
        }

        return redirect()->route('tenant.setup.index', ['tenant' => tenant('id')])->with('success', 'Settings saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
