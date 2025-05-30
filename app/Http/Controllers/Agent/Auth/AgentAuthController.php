<?php

// app/Http/Controllers/Agent/Auth/AgentAuthController.php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('agent.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('agent')->attempt($credentials)) {
            return redirect()->route('agent.dashboard');
        }

        return redirect()->back()->with('error', 'Email ou mot de passe incorrect');
    }

    public function logout()
    {
        Auth::guard('agent')->logout();
        return redirect()->route('agent.login');
    }
}
