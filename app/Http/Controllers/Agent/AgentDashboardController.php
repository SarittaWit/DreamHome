<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\VisitRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgentDashboardController extends Controller
{
   public function dashboard()
{
    
    // Visites aujourd'hui
    $visitsToday = VisitRequest::whereDate('scheduled_date', today())->count();

    // Propriétés actives
    $activeProperties = Property::where('status', 'active')->count();

    // Ventes ce mois
    $salesThisMonth = Property::where('status', 'sold')
        ->whereMonth('updated_at', now()->month)
        ->whereYear('updated_at', now()->year)
        ->count();

    // Visites à venir (prochaines 7 jours)
    $upcomingVisits = VisitRequest::with('property')
        ->where('status', 'confirmed')
        ->whereBetween('scheduled_date', [today(), today()->addDays(7)])
        ->orderBy('scheduled_date')
        ->get();

    // Dernières propriétés ajoutées
    $latestProperties = Property::latest()
        ->take(5)
        ->get();

    // Toutes les propriétés (sans pagination)
    $properties = Property::latest()->get();

    // Ajoutez cette ligne pour définir $visites
    $visites = VisitRequest::with('property')->latest()->take(5)->get();

    return view('dashboard.agent_dashboard', compact(
        'visitsToday',
        'activeProperties',
        'salesThisMonth',
        'upcomingVisits',
        'latestProperties',
        'properties',
        'visites' // Maintenant cette variable est définie
    ));
}

    public function visites(Request $request)
    {
        $query = VisitRequest::with('property');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $visites = $query->latest()->get();

        return view('dashboard.agent_visites', compact('visites'));
    }

    public function confirmer($id)
    {
        $visit = VisitRequest::findOrFail($id);
        $visit->update(['status' => 'confirmed']);

        return back()->with('success', 'Visite confirmée avec succès');
    }

    public function annuler($id)
    {
        $visit = VisitRequest::findOrFail($id);
        $visit->update(['status' => 'cancelled']);

        return back()->with('success', 'Visite annulée avec succès');
    }

    public function show($id)
    {
        $visit = VisitRequest::with('property')->findOrFail($id);
        return view('dashboard.agent_visite_modal', compact('visit'));
    }
}
