<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('items.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('items.index');
    })->name('dashboard');
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::delete('/items/{item}', [AdminController::class, 'deleteItem'])->name('admin.items.delete');
    });

    // Tambah ini
    Route::get('/profile', function () {
        return redirect()->route('items.index');
    })->name('profile.edit');

    Route::resource('items', ItemController::class);
    Route::post('/items/{item}/claim', [ClaimController::class, 'store'])->name('claims.store');
    Route::post('/claims/{claim}/approve', [ClaimController::class, 'approve'])->name('claims.approve');
    Route::post('/claims/{claim}/reject', [ClaimController::class, 'reject'])->name('claims.reject');
});

require __DIR__ . '/auth.php';
