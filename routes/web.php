<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;


Route::get('/', function () {
    return view('auth/login');
});

Route::get('/tasks', [TaskController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);
Route::post('/tasks', [TaskController::class, 'store'])->name('dashboard')->middleware(['auth', 'verified']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified']) // Ensure the user is authenticated and is an admin
    ->name('admin.dashboard');


Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
    ->middleware(['auth', 'verified']) // Ensure the user is authenticated and is an admin
    ->name('users.toggleActive');

Route::view('/not-active', 'not-active')->name('not-active');

require __DIR__.'/auth.php';
