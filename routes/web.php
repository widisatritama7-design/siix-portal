<?php

use App\Livewire\User\UserManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/users', UserManagement::class)->name('users');
});

require __DIR__.'/settings.php';