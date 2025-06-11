<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch settings from DB
        $status_enabled = Settings::where('key', 'status_enabled')->value('value') === 'true';
        $status_query_ip = Settings::where('key', 'status_query_ip')->value('value') ?? '';
        $status_query_port = Settings::where('key', 'status_query_port')->value('value') ?? '';

        return Inertia::render('Dashboard', [
            'status_enabled' => $status_enabled,
            'status_query_ip' => $status_query_ip,
            'status_query_port' => $status_query_port,
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
