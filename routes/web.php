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
Route::post('/api/data-maps/{id}', [App\Http\Controllers\CommandCenterController::class, 'updateDataMap'])->name('api.data-maps.update');
Route::delete('/api/data-maps/{id}', [App\Http\Controllers\CommandCenterController::class, 'deleteDataMap'])->name('api.data-maps.destroy');

// Road Data Routes
Route::post('/api/jalans', [App\Http\Controllers\CommandCenterController::class, 'saveRoadData'])->name('api.jalans.store');
Route::get('/api/jalans', [App\Http\Controllers\CommandCenterController::class, 'getRoadData'])->name('api.jalans.index');
Route::post('/api/jalans/{id}', [App\Http\Controllers\CommandCenterController::class, 'updateRoadData'])->name('api.jalans.update');
Route::delete('/api/jalans/{id}', [App\Http\Controllers\CommandCenterController::class, 'deleteRoadData'])->name('api.jalans.destroy');

// PBB (Pajak Bumi & Bangunan) Routes
Route::post('/api/pbb', [App\Http\Controllers\CommandCenterController::class, 'savePBB'])->name('api.pbb.store');
Route::get('/api/pbb', [App\Http\Controllers\CommandCenterController::class, 'getPBB'])->name('api.pbb.index');
Route::post('/api/pbb/{id}', [App\Http\Controllers\CommandCenterController::class, 'updatePBB'])->name('api.pbb.update');
Route::delete('/api/pbb/{id}', [App\Http\Controllers\CommandCenterController::class, 'deletePBB'])->name('api.pbb.destroy');

// Test route for PBB display
Route::get('/test-pbb-simple', function () {
    return view('test-pbb-simple');
});

// Test route for PBB module functions
Route::get('/test-pbb-module', function () {
    return view('test-pbb-module');
});
