<?php

use Illuminate\Support\Facades\Route;
use APP\Http\Controllers\ItemController;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/', [ItemsController::class, 'index'])->name('items.index');
Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
Route::patch('/items/{id}/update-name', [ItemController::class, 'updateName'] )->name('items.updateName');
Route::patch('/items/{id}/decrement', [ItemController::class, 'decrement'])->name('items.decrement');
Route::delete('/items/{id}', [ItemController::class, 'delete'])->name('items.delete');
Route::patch('items/{id}/restore', [ItemController::class, 'restore'])->name('items.restore');



