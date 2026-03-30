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
use App\Livewire\ESD\GB\GroundMonitorBoxDetailManagement;
use App\Livewire\ESD\GB\GroundMonitorBoxManagement;
use App\Livewire\ESD\GB\GroundMonitorBoxShow;
use App\Livewire\ESD\Glove\GloveDetailManagement;
use App\Livewire\ESD\Glove\GloveManagement;
use App\Livewire\ESD\Glove\GloveShow;
use App\Livewire\ESD\Ionizer\IonizerDetailManagement;
use App\Livewire\ESD\Ionizer\IonizerManagement;
use App\Livewire\ESD\Ionizer\IonizerShow;
use App\Livewire\ESD\Jig\JigDetailManagement;
use App\Livewire\ESD\Jig\JigManagement;
use App\Livewire\ESD\Jig\JigShow;
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

    // Ground Monitor Box
    Route::livewire('esd/ground-monitor-boxs', GroundMonitorBoxManagement::class)->name('esd.ground-monitor-boxs');
    Route::livewire('/esd/ground-monitor-boxs/{id}', GroundMonitorBoxShow::class)->name('esd.ground-monitor-boxs.show');
    Route::livewire('esd/ground-monitor-box-details', GroundMonitorBoxDetailManagement::class)->name('esd.ground-monitor-box-details');
    
    // Glove
    Route::livewire('esd/gloves', GloveManagement::class)->name('esd.gloves');
    Route::livewire('/esd/gloves/{id}', GloveShow::class)->name('esd.gloves.show');
    Route::livewire('esd/glove-details', GloveDetailManagement::class)->name('esd.glove-details');

    // Ionizer
    Route::livewire('esd/ionizers', IonizerManagement::class)->name('esd.ionizers');
    Route::livewire('/esd/ionizers/{id}', IonizerShow::class)->name('esd.ionizers.show');
    Route::livewire('esd/ionizer-details', IonizerDetailManagement::class)->name('esd.ionizer-details');

    // Jig
    Route::livewire('esd/jigs', JigManagement::class)->name('esd.jigs');
    Route::livewire('/esd/jigs/{id}', JigShow::class)->name('esd.jigs.show');
    Route::livewire('esd/jig-details', JigDetailManagement::class)->name('esd.jig-details');

});
