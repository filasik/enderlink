<?php

namespace App\Http\Controllers;

use App\Models\Setup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all setup records
        //$setups = Setup::all();

        $setups = [];

        // Return the index view with setups data
        return Inertia::render('Setup/Index', [
            'setups' => $setups,
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
    public function show(Setup $setup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setup $setup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setup $setup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setup $setup)
    {
        //
    }
}
