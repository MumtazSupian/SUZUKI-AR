<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PiutangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/bp', [PiutangController::class, 'indexBp']);
Route::post('/bp', [PiutangController::class, 'storeBp']);
Route::get('/bp/{id}/edit', [PiutangController::class, 'editBp'])->whereNumber('id');
Route::put('/bp/{id}', [PiutangController::class, 'updateBp'])->whereNumber('id');
Route::delete('/bp/{id}', [PiutangController::class, 'destroyBp'])->whereNumber('id');

Route::get('/gr/{branch}', [PiutangController::class, 'indexGr'])
    ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi']);
Route::post('/gr/{branch}', [PiutangController::class, 'storeGr'])
    ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi']);
Route::get('/gr/{branch}/{id}/edit', [PiutangController::class, 'editGr'])
    ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])
    ->whereNumber('id');
Route::put('/gr/{branch}/{id}', [PiutangController::class, 'updateGr'])
    ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])
    ->whereNumber('id');
Route::delete('/gr/{branch}/{id}', [PiutangController::class, 'destroyGr'])
    ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])
    ->whereNumber('id');
