<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

// Dashboard & Profile (accessible to any authenticated and verified user)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
    Route::view('/projects', 'projects')->name('projects');
    Route::view('/users', 'users')->name('users');
    Route::view('/companies', 'companies')->name('companies');
});




// Include authentication routes
require __DIR__ . '/auth.php';
