<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

// Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::patch('/items/{id}/update-name', [ItemController::class, 'updateName'])->name('items.updateName');
Route::patch('/items/{id}/decrement', [ItemController::class, 'decrement'])->name('items.decrement');
Route::patch('/items/{id}/increment', [ItemController::class, 'increment'])->name('items.increment');
Route::patch('/items/{id}/quantity', [ItemController::class, 'updateQuantity'])->name('items.updateQuantity');
Route::delete('/items/{id}', [ItemController::class, 'delete'])->name('items.delete');
Route::patch('/items/{id}/restore', [ItemController::class, 'restore'])->name('items.restore');



