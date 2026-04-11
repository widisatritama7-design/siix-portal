<?php

use App\Livewire\MTC\Master\MasterAreaManagement;
use App\Livewire\MTC\Master\MasterLineManagement;
use App\Livewire\MTC\Master\MasterLocationManagement;
use App\Livewire\MTC\Master\MasterMachineManagement;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    // Master Area
    Route::livewire('mtc/master-areas', MasterAreaManagement::class)->name('mtc.master-areas');

    // Master Location
    Route::livewire('mtc/master-locations', MasterLocationManagement::class)->name('mtc.master-locations');

    // Master Line
    Route::livewire('mtc/master-lines', MasterLineManagement::class)->name('mtc.master-lines');

    // Master Machine
    Route::livewire('mtc/master-machines', MasterMachineManagement::class)->name('mtc.master-machines');

});
