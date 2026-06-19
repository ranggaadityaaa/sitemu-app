<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('items.index');
});

Route::middleware(['auth', 'banned'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('items.index');
    })->name('dashboard');

    Route::get('/profile', function () {
        return redirect()->route('items.index');
    })->name('profile.edit');

    Route::resource('items', ItemController::class);
    Route::post('/items/{item}/claim', [ClaimController::class, 'store'])->name('claims.store');
    Route::post('/claims/{claim}/approve', [ClaimController::class, 'approve'])->name('claims.approve');
    Route::post('/claims/{claim}/reject', [ClaimController::class, 'reject'])->name('claims.reject');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/items/{item}', [AdminController::class, 'deleteItem'])->name('admin.items.delete');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('admin.users.unban');
});

require __DIR__ . '/auth.php';