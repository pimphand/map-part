<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Command Center Routes
Route::get('/data-penduduk', [App\Http\Controllers\CommandCenterController::class, 'dataPenduduk'])->name('dataPenduduk');

Route::get('/command-center', [App\Http\Controllers\CommandCenterController::class, 'index'])->name('command-center');
Route::get('/api/village-data', [App\Http\Controllers\CommandCenterController::class, 'getVillageData'])->name('api.village-data');
Route::post('/api/village-data', [App\Http\Controllers\CommandCenterController::class, 'updateVillageData'])->name('api.village-data.update');
