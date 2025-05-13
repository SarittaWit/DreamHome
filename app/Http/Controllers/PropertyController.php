<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Notifications\NewPropertyNotification;
use App\Models\User;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::query();

        // 🔍 فلترة حسب الموقع
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // ✅ فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 💰 فلترة حسب السعر الأقصى
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $properties = $query->paginate(10); // أو أي عدد تبغيه

        return view('properties.index', compact('properties'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'location' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|in:disponible,vendu',
            'image' => 'nullable|image|max:2048',
        ]);
    
        $data = $request->only(['title', 'description', 'location', 'price', 'status']);
        $data['user_id'] = auth()->id(); // ✅ ربط العقار بالمستخدم الحالي
    
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }
    
        $property = Property::create($data); // ✅ إنشاء العقار مرة وحدة فقط
    
        // 🔔 إرسال الإشعار إلى جميع الـ admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewPropertyNotification($property));
        }
    
        return redirect()->route('properties.index')->with('success', 'Propriété ajoutée avec succès ✅');
    }



    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'location' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|in:disponible,vendu',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'location', 'price', 'status']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($data);

        return redirect()->route('properties.index')->with('success', 'Propriété mise à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {

        $property->delete();
        return redirect()->route('properties.index')->with('success', 'Propriété supprimée avec succès.');

    }
}
