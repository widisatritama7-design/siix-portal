<?php

use App\Livewire\MTC\Daily\Fuji\DailyFujiCreate;
use App\Livewire\MTC\Daily\Fuji\DailyFujiEdit;
use App\Livewire\MTC\Daily\Panasonic\DailyPanasonicCreate;
use App\Livewire\MTC\Daily\Panasonic\DailyPanasonicEdit;
use App\Livewire\MTC\Master\MasterAreaManagement;
use App\Livewire\MTC\Master\MasterLineManagement;
use App\Livewire\MTC\Master\MasterLineShow;
use App\Livewire\MTC\Master\MasterLocationManagement;
use App\Livewire\MTC\Master\MasterMachineManagement;
use App\Livewire\MTC\Master\StencilManagement;
use App\Models\MTC\Daily\DailyFuji;
use App\Models\MTC\Daily\DailyPanasonic;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    // Master Area
    Route::livewire('mtc/master-areas', MasterAreaManagement::class)->name('mtc.master-areas');

    // Master Location
    Route::livewire('mtc/master-locations', MasterLocationManagement::class)->name('mtc.master-locations');

    // Master Machine
    Route::livewire('mtc/master-machines', MasterMachineManagement::class)->name('mtc.master-machines');

    // Master Line
    Route::livewire('mtc/master-lines', MasterLineManagement::class)->name('mtc.master-lines');
    Route::livewire('mtc/master-lines/{id}', MasterLineShow::class)->name('mtc.master-lines.show');

    // Daily Fuji
    Route::get('mtc/master-lines/{masterLineId}/daily-fuji/create', DailyFujiCreate::class)->name('mtc.daily-fuji.create');
    Route::get('mtc/master-lines/{masterLineId}/daily-fuji/{dailyFujiId}/edit', DailyFujiEdit::class)->name('mtc.daily-fuji.edit');
    Route::get('mtc/master-lines/dailyFuji/{dailyFuji}', function ($id) {$dailyFuji = DailyFuji::with(['masterLine', 'creator', 'updater', 'approvedBy'])->findOrFail($id); return view('mtc.daily.fuji.daily-fuji-print', compact('dailyFuji')); })->name('print.daily-fuji');

    // Daily Panasonic
    Route::get('mtc/master-lines/{masterLineId}/daily-panasonic/create', DailyPanasonicCreate::class)->name('mtc.daily-panasonic.create');
    Route::get('mtc/master-lines/{masterLineId}/daily-panasonic/{dailyPanasonicId}/edit', DailyPanasonicEdit::class)->name('mtc.daily-panasonic.edit');
    Route::get('print/daily-panasonic/{dailyPanasonic}', function ($id) {$dailyPanasonic = DailyPanasonic::with(['masterLine', 'creator', 'updater', 'approvedBy'])->findOrFail($id); return view('mtc.daily.panasonic.daily-panasonic-print', compact('dailyPanasonic')); })->name('print.daily-panasonic');

    // Stencil
    Route::livewire('mtc/stencils', StencilManagement::class)->name('mtc.stencils');

});
