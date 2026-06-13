<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('items.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('items.index');
    })->name('dashboard');

    // Tambah ini
    Route::get('/profile', function () {
        return redirect()->route('items.index');
    })->name('profile.edit');

    Route::resource('items', ItemController::class);
    Route::post('/items/{item}/claim', [ClaimController::class, 'store'])->name('claims.store');
    Route::post('/claims/{claim}/approve', [ClaimController::class, 'approve'])->name('claims.approve');
    Route::post('/claims/{claim}/reject', [ClaimController::class, 'reject'])->name('claims.reject');
});

require __DIR__.'/auth.php';