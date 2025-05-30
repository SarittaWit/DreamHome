<?php

use App\Http\Controllers\Agent\Auth\AgentAuthController;
use App\Http\Controllers\Agent\AgentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AgentAuthController::class, 'showLoginForm'])->name('agent.login');
Route::post('/login', [AgentAuthController::class, 'login'])->name('agent.login.submit');
Route::post('/logout', [AgentAuthController::class, 'logout'])->name('agent.logout');

Route::middleware('auth:agent')->group(function () {
    Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('agent.dashboard');
});
