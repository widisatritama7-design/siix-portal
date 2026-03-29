<?php

use App\Livewire\ESD\EG\EquipmentGroundDetailManagement;
use App\Livewire\ESD\EG\EquipmentGroundManagement;
use App\Livewire\ESD\EG\EquipmentGroundShow;
use App\Livewire\ESD\Flooring\FlooringDetailManagement;
use App\Livewire\ESD\Flooring\FlooringManagement;
use App\Livewire\ESD\Flooring\FlooringShow;
use App\Livewire\ESD\Garment\GarmentDetailManagement;
use App\Livewire\ESD\Garment\GarmentManagement;
use App\Livewire\ESD\Garment\GarmentShow;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    // Equipment Ground
    Route::livewire('esd/equipment-grounds', EquipmentGroundManagement::class)->name('esd.equipment-grounds');
    Route::livewire('/esd/equipment-grounds/{id}', EquipmentGroundShow::class)->name('esd.equipment-grounds.show');
    Route::livewire('esd/equipment-ground-details', EquipmentGroundDetailManagement::class)->name('esd.equipment-ground-details');

    // Flooring
    Route::livewire('esd/floorings', FlooringManagement::class)->name('esd.floorings');
    Route::livewire('/esd/floorings/{id}', FlooringShow::class)->name('esd.floorings.show');
    Route::livewire('esd/flooring-details', FlooringDetailManagement::class)->name('esd.flooring-details');

    // Garment
    Route::livewire('esd/garments', GarmentManagement::class)->name('esd.garments');
    Route::livewire('/esd/garments/{id}', GarmentShow::class)->name('esd.garments.show');
    Route::livewire('esd/garment-details', GarmentDetailManagement::class)->name('esd.garment-details');
    
    
});
