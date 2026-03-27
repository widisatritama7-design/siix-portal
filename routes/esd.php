<?php

use App\Livewire\ESD\ESD;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::livewire('esd/test', ESD::class)->name('esd.test');
    
});
