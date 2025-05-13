<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Property;

use App\Models\User;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $agentsCount = User::where('role', 'agent')->count();
        $clientsCount = User::where('role', 'client')->count();
        $propertiesCount = Property::count();
        $availableCount = Property::where('status', 'disponible')->count();
        $soldCount = Property::where('status', 'vendu')->count();
    
        // بيانات الرسم البياني الشهري
        $months = [];
        $propertyCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = \Carbon\Carbon::create()->month($i)->locale('fr')->isoFormat('MMMM');
            $propertyCounts[] = Property::whereMonth('created_at', $i)->count();
        }
    
        // آخر العقارات
        $latestProperties = Property::latest()->take(6)->with('user')->get();
    
        // آخر الأنشطة (مثال بسيط)
        $recentAgents = User::where('role', 'agent')->latest()->take(3)->get();
    
        return view('dashboard', compact(
            'usersCount',
            'agentsCount',
            'clientsCount',
            'propertiesCount',
            'availableCount',
            'soldCount',
            'months',
            'propertyCounts',
            'latestProperties',
            'recentAgents'
        ));
    }
}
