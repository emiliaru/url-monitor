<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Services\WebsiteMonitorService;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    protected $monitorService;

    public function __construct(WebsiteMonitorService $monitorService)
    {
        $this->monitorService = $monitorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = Website::with('latestCheck')->get();
        return view('websites.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('websites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'check_interval' => 'required|integer|min:1',
            'category' => 'nullable|string|max:255',
        ]);

        $website = Website::create($validated);
        
        // Wykonaj pierwsze sprawdzenie strony
        $this->monitorService->checkWebsite($website);

        return redirect()->route('websites.index')
            ->with('success', 'Strona została dodana do monitorowania.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website)
    {
        $website->load(['checks' => function ($query) {
            $query->latest()->limit(100);
        }]);
        
        return view('websites.show', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        return view('websites.edit', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'check_interval' => 'required|integer|min:1',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $website->update($validated);

        return redirect()->route('websites.index')
            ->with('success', 'Strona została zaktualizowana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website)
    {
        $website->delete();

        return redirect()->route('websites.index')
            ->with('success', 'Strona została usunięta z monitorowania.');
    }

    /**
     * Ręczne sprawdzenie strony.
     */
    public function check(Website $website)
    {
        $check = $this->monitorService->checkWebsite($website);

        return redirect()->back()
            ->with('success', 'Sprawdzenie strony zostało wykonane.');
    }
}
