<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Main list/dashboard
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

// Add task routes
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Edit task routes
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

// Status toggle shortcut
Route::patch('/tasks/{id}/status', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');

// Delete task
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');