<?php

use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::redirect('regions', 'regions/index');
    Route::get('regions/index', action: [RegionController::class, 'index'])->name('regions.index');
    Route::get('regions/create', action: [RegionController::class, 'create'])->name('regions.create');
    Route::post('regions/store', [RegionController::class, 'store'])->name('regions.store');
    Route::get('regions/{id}/edit', action: [RegionController::class, 'edit'])->name('regions.edit');
    Route::put('regions/{id}/update', [RegionController::class, 'update'])->name('regions.update');
    Route::delete('regions/{id}/destroy', [RegionController::class, 'destroy'])->name('regions.destroy');
});
