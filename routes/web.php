<?php

use Illuminate\Support\Facades\Route;

// Command Center Routes
Route::get('/data-penduduk', [App\Http\Controllers\CommandCenterController::class, 'dataPenduduk'])->name('dataPenduduk');

Route::get('/', [App\Http\Controllers\CommandCenterController::class, 'index'])->name('command-center');
Route::get('/command-center/village-data', [App\Http\Controllers\CommandCenterController::class, 'getVillageData'])->name('command-center.village-data');
Route::get('/api/village-data', [App\Http\Controllers\CommandCenterController::class, 'getVillageData'])->name('api.village-data');
Route::post('/api/village-data', [App\Http\Controllers\CommandCenterController::class, 'updateVillageData'])->name('api.village-data.update');

// Data Map Routes
Route::post('/api/data-maps', [App\Http\Controllers\CommandCenterController::class, 'simpanDataMap'])->name('api.data-maps.store');
Route::get('/api/data-maps', [App\Http\Controllers\CommandCenterController::class, 'getDataMaps'])->name('api.data-maps.index');

// Road Data Routes
Route::post('/api/jalans', [App\Http\Controllers\CommandCenterController::class, 'saveRoadData'])->name('api.jalans.store');
Route::get('/api/jalans', [App\Http\Controllers\CommandCenterController::class, 'getRoadData'])->name('api.jalans.index');
Route::delete('/api/jalans/{id}', [App\Http\Controllers\CommandCenterController::class, 'deleteRoadData'])->name('api.jalans.destroy');
