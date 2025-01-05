<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\NoteController;


Route::get('/', function () {
    return view('auth/login');
});

//notes controllers
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');


#@todo fix resource route for tasks and notes
//Route::resource('tasks', TaskController::class)->middleware(['auth', 'verified']);

//tasks controllers
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index')->middleware(['auth', 'verified']);
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware(['auth', 'verified']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware(['auth', 'verified']);
Route::get('/search', [TaskController::class, 'search'])->name('tasks.search')->middleware(['auth', 'verified']);
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit')->middleware(['auth', 'verified']);
Route::post('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update')->middleware(['auth', 'verified']);
Route::get('/tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter')->middleware(['auth', 'verified']);




//auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Ensure the user is authenticated and is an admin
Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified','admin'])
    ->name('admin.dashboard');


Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
    ->middleware(['auth', 'verified'])
    ->name('users.toggleActive');

Route::view('/not-active', 'not-active')->name('not-active');

require __DIR__.'/auth.php';
