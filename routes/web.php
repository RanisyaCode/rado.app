<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Quick Demo Login (Rani Syaeka)
Route::get('/demo-login', function () {
    $user = User::where('email', 'ranisyaeka48@gmail.com')->first();
    if ($user) {
        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Berhasil masuk sebagai akun demo: Rani Syaeka!');
    }
    return redirect()->route('login');
})->name('demo.login');

Route::middleware(['auth'])->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Tugas
    Route::get('/tasks/today', [TaskController::class, 'today'])->name('tasks.today');
    Route::get('/tasks/completed', [TaskController::class, 'completed'])->name('tasks.completed');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');
    Route::resource('tasks', TaskController::class);

    // Manajemen Kategori
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);

    // Kalender Tugas
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // Profil & Pengaturan Akun (Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
