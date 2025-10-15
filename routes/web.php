<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiteSettingController;

Route::get('/', function () {
    return view('welcome');
});

// Generic dashboard route used by auth scaffolding; redirects per user_type
// Route::get('/dashboard', function () {
//     $user = request()->user();
//     if ($user && strtolower((string) $user->user_type) === 'admin') {
//         return redirect()->route('admin.dashboard');
//     }
//     return redirect()->route('user.dashboard');
// })->middleware(['auth'])->name('dashboard');

// User routes
Route::middleware(['auth', 'usertype:user'])->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
});

// Admin routes
Route::middleware(['auth', 'usertype:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Site Settings
    Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::get('site-settings/{site_setting}/edit', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::patch('site-settings/{site_setting}', [SiteSettingController::class, 'update'])->name('site-settings.update');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
