<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\VisitRequest;
use Illuminate\Http\Request;

class VisitRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitRequest::with('property');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $visites = $query->latest()->get();

        return view('dashboard.visites.index', compact('visites'));
    }
}
