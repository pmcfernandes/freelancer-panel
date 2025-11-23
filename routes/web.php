<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExpenseController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/expenses/{id}/download', [ExpenseController::class, 'download'])->name('expenses.download');
