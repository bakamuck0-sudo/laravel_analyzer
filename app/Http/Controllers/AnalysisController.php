<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\Contracts\Auth\Authenticatable;
use App\Models\Analysis as ModelsAnalysis;
use App\Jobs\AnalyzeUrlJob;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $analysis = Analysis::create([
            'user_id' => Auth::id(),
            'url' => 'https://example.com',
            'status' => 'pending',
        ]);
        AnalyzeUrlJob::dispatch($analysis);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url|max:2048',
        ]);
        $analysis = Auth::user()->analyses()->create([
             'url' => $validated['url'],
             'status' => 'pending',
         ]);
        AnalyzeUrlJob::dispatch($analysis);
        return redirect()->back()->with('status', 'Analysis request submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Analysis $analysis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Analysis $analysis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Analysis $analysis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Analysis $analysis)
    {
        //
    }
}
