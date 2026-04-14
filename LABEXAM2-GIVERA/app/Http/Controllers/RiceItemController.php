<?php

namespace App\Http\Controllers;

use App\Models\RiceItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $riceItems = RiceItem::latest()->paginate(10);

        return view('rice_items.index', compact('riceItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('rice_items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price_per_kilogram' => ['required', 'numeric', 'min:0.01'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        RiceItem::create($validated);

        return redirect()->route('rice-items.index')->with('success', 'Rice product added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiceItem $riceItem): View
    {
        return view('rice_items.edit', compact('riceItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiceItem $riceItem): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price_per_kilogram' => ['required', 'numeric', 'min:0.01'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $riceItem->update($validated);

        return redirect()->route('rice-items.index')->with('success', 'Rice product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiceItem $riceItem): RedirectResponse
    {
        if ($riceItem->orderItems()->exists()) {
            return redirect()->route('rice-items.index')->with('error', 'Rice product cannot be deleted because it is already part of an order.');
        }

        $riceItem->delete();

        return redirect()->route('rice-items.index')->with('success', 'Rice product deleted successfully.');
    }
}
