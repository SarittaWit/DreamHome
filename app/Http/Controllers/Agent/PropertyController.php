<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
public function index(Request $request)
{
    $query = Property::where('agent_id', auth('agent')->id())
                ->with('images')
                ->latest();

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $properties = $query->paginate(12);
    $properties = Property::with('images')->where('agent_id', auth('agent')->id())->get();

    return view('dashboard.agent_dashboard', compact('properties'));
}

    public function create()
    {
        return view('dashboard.agent_properties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'status' => 'required|in:active,pending,sold,rented',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $propertyData = $request->except('image');

        if ($request->hasFile('image')) {
            $propertyData['image'] = $request->file('image')->store('properties', 'public');
        }

        Property::create($propertyData);

        return redirect()->route('agent.properties.index')
            ->with('success', 'Propriété créée avec succès');
    }

    public function show(Property $property)
    {
        return view('dashboard.agent_properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        return view('dashboard.agent_properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'status' => 'required|in:active,pending,sold,rented',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $propertyData = $request->except('image');

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($property->image) {
                Storage::disk('public')->delete($property->image);
            }
            $propertyData['image'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($propertyData);

        return redirect()->route('agent.properties.index')
            ->with('success', 'Propriété mise à jour avec succès');
    }

    public function destroy(Property $property)
    {
        if ($property->image) {
            Storage::disk('public')->delete($property->image);
        }

        $property->delete();

        return redirect()->route('agent.properties.index')
            ->with('success', 'Propriété supprimée avec succès');
    }
}
