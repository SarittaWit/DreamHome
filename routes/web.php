<?php

use App\Http\Controllers\Agent\Auth\AgentAuthController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\PropertyController;



Route::prefix('agent')->group(function () {
    Route::get('/login', [AgentAuthController::class, 'showLoginForm'])->name('agent.login');
    Route::post('/login', [AgentAuthController::class, 'login'])->name('agent.login.submit');
    Route::post('/logout', [AgentAuthController::class, 'logout'])->name('agent.logout');

    Route::middleware('auth:agent')->group(function () {
        Route::get('/dashboard', [AgentDashboardController::class, 'dashboard'])->name('agent.dashboard');
        Route::get('/visites', [AgentDashboardController::class, 'visites'])->name('agent.visites');
        Route::post('/visites/{id}/confirmer', [AgentDashboardController::class, 'confirmer'])->name('agent.visites.confirmer');
        Route::post('/visites/{id}/annuler', [AgentDashboardController::class, 'annuler'])->name('agent.visites.annuler');
        Route::get('/visites/{id}', [AgentDashboardController::class, 'show'])->name('agent.visites.show');

            // Routes pour les propriétés
    Route::get('/properties', [PropertyController::class, 'index'])->name('agent.properties.index');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('agent.properties.create');
    Route::post('/properties/store', [PropertyController::class, 'store'])->name('agent.properties.store');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('agent.properties.show');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('agent.properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('agent.properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('agent.properties.destroy');

    });
});



// routes/agent.php




