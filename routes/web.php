<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\NoteController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/expenses/{id}/download', [ExpenseController::class, 'download'])->name('expenses.download');
Route::get('/mettings/calendar', [NoteController::class, 'calendar'])->name('notes.calendar');
