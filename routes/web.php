<?php

use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;

Route::get('/',[ReservationController::class,'index'])->name('HomePage');
Route::get('/Agents',function(){
    return view('components.parties.AgentsSection');
})->name('agent');

Route::middleware('auth')->group(function () {
Route::get('/reservation/create',[ReservationController::class,'create'])->name('reservation.create');
Route::post('/reservation/store',[ReservationController::class,'store'])->name('reservation.store');
});

require __DIR__.'/auth.php';
