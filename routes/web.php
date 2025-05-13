<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MessageController;

require __DIR__.'/auth.php';


Route::middleware(['auth','admin'])->group(function () {
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('properties', \App\Http\Controllers\PropertyController::class);

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

    Route::post('/notifications/mark-all', function () {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        return back();
    })->name('notifications.markAllAsRead');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');
    Route::delete('/notifications', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');


    Route::resource('permissions', PermissionController::class);
    Route::put('/permissions/sync/{role}', [PermissionController::class, 'syncPermissions'])->name('permissions.sync');


    Route::resource('roles', \App\Http\Controllers\RoleController::class);
});


