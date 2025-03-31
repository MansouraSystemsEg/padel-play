<?php

use App\Http\Controllers\CourtController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::redirect('courts', 'courts/index');
    Route::get('courts/index', action: [CourtController::class, 'index'])->name('courts.index');
    Route::get('courts/create', action: [CourtController::class, 'create'])->name('courts.create');
    Route::post('courts/store', [CourtController::class, 'store'])->name('courts.store');
    Route::get('courts/{id}/edit', action: [CourtController::class, 'edit'])->name('courts.edit');
    Route::put('courts/{id}/update', [CourtController::class, 'update'])->name('courts.update');
    Route::delete('courts/{id}/destroy', [CourtController::class, 'destroy'])->name('courts.destroy');
});
