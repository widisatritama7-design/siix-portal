<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\LockerStatusController;
use App\Livewire\ESD\Activity\EsdCalendar;
use App\Livewire\ESD\Activity\EventCalendar;
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
use App\Livewire\ESD\Insulatif\InsulatifCheckManagement;
use App\Livewire\ESD\Ionizer\IonizerDetailManagement;
use App\Livewire\ESD\Ionizer\IonizerManagement;
use App\Livewire\ESD\Ionizer\IonizerShow;
use App\Livewire\ESD\Jig\JigDetailManagement;
use App\Livewire\ESD\Jig\JigManagement;
use App\Livewire\ESD\Jig\JigShow;
use App\Livewire\ESD\Locker\LockerStatusManagement;
use App\Livewire\ESD\Magazine\MagazineDetailManagement;
use App\Livewire\ESD\Magazine\MagazineManagement;
use App\Livewire\ESD\Magazine\MagazineShow;
use App\Livewire\ESD\Packaging\PackagingDetailManagement;
use App\Livewire\ESD\Packaging\PackagingManagement;
use App\Livewire\ESD\Packaging\PackagingShow;
use App\Livewire\ESD\Patrol\PatrolManagement;
use App\Livewire\ESD\PQ\ProductQualificationManagement;
use App\Livewire\ESD\PQ\ProductQualificationShow;
use App\Livewire\ESD\Print\MultiModelQrPrinter;
use App\Livewire\ESD\Shower\ShowerDetailManagement;
use App\Livewire\ESD\Shower\ShowerManagement;
use App\Livewire\ESD\Shower\ShowerShow;
use App\Livewire\ESD\Soldering\SolderingDetailManagement;
use App\Livewire\ESD\Soldering\SolderingManagement;
use App\Livewire\ESD\Soldering\SolderingShow;
use App\Livewire\ESD\Stock\MaterialManagement;
use App\Livewire\ESD\Stock\TransactionManagement;
use App\Livewire\ESD\Worksurface\WorksurfaceDetailManagement;
use App\Livewire\ESD\Worksurface\WorksurfaceManagement;
use App\Livewire\ESD\Worksurface\WorksurfaceShow;
use App\Livewire\ESD\WS\WristStrapManagement;
use App\Models\HR\Employee;
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

    // Magazine
    Route::livewire('esd/magazines', MagazineManagement::class)->name('esd.magazines');
    Route::livewire('/esd/magazines/{id}', MagazineShow::class)->name('esd.magazines.show');
    Route::livewire('esd/magazine-details', MagazineDetailManagement::class)->name('esd.magazine-details');

    // Packaging
    Route::livewire('esd/packagings', PackagingManagement::class)->name('esd.packagings');
    Route::livewire('/esd/packagings/{id}', PackagingShow::class)->name('esd.packagings.show');
    Route::livewire('esd/packaging-details', PackagingDetailManagement::class)->name('esd.packaging-details');

    // Soldering
    Route::livewire('esd/solderings', SolderingManagement::class)->name('esd.solderings');
    Route::livewire('/esd/solderings/{id}', SolderingShow::class)->name('esd.solderings.show');
    Route::livewire('esd/soldering-details', SolderingDetailManagement::class)->name('esd.soldering-details');

    // Worksurface
    Route::livewire('esd/worksurfaces', WorksurfaceManagement::class)->name('esd.worksurfaces');
    Route::livewire('/esd/worksurfaces/{id}', WorksurfaceShow::class)->name('esd.worksurfaces.show');
    Route::livewire('esd/worksurface-details', WorksurfaceDetailManagement::class)->name('esd.worksurface-details');

    // Shower
    Route::livewire('esd/showers', ShowerManagement::class)->name('esd.showers');
    Route::livewire('/esd/showers/{id}', ShowerShow::class)->name('esd.showers.show');
    Route::livewire('esd/shower-details', ShowerDetailManagement::class)->name('esd.shower-details');

    // Product Qualification
    Route::livewire('esd/product-qualifications', ProductQualificationManagement::class)->name('esd.product-qualifications');
    Route::livewire('/esd/product-qualifications/{id}', ProductQualificationShow::class)->name('esd.product-qualifications.show');

    // Stock
    Route::livewire('esd/materials', MaterialManagement::class)->name('esd.materials');
    Route::livewire('esd/transactions', TransactionManagement::class)->name('esd.transactions');

    // Event Calendar
    Route::get('/esd/events', EventCalendar::class)->name('esd.events');
    Route::get('/esd/events/create', [EventController::class, 'create'])->name('esd.events.create');
    Route::get('/calendar-events', [EventController::class, 'getEvents']);

    // Insulatif Check
    Route::livewire('esd/insulatif-checks', InsulatifCheckManagement::class)->name('esd.insulatif-checks');

    // Wrist Strap
    Route::livewire('esd/wrist-straps', WristStrapManagement::class)->name('esd.wrist-straps');

    // Patrol
    Route::livewire('esd/patrols', PatrolManagement::class)->name('esd.patrols');

    // Locker
    Route::livewire('esd/lockers', LockerStatusManagement::class)->name('esd.lockers');

    // ESD Calendar
    Route::get('/esd/calendar', EsdCalendar::class)->name('esd.calendar');

    // Print QR-Code
    Route::get('/esd/print', MultiModelQrPrinter::class)->name('esd.print');

});

Route::get('/locker-status', [LockerStatusController::class, 'index'])->name('locker-status.index');
Route::post('/locker-status', [LockerStatusController::class, 'store'])->name('locker-status.store');
Route::put('/locker-status/{lockerStatus}', [LockerStatusController::class, 'update'])->name('locker-status.update');
Route::post('/locker/update', [LockerStatusController::class, 'update'])->name('locker.update');
Route::get('/employee/{nik}', [App\Http\Controllers\LockerStatusController::class, 'getEmployee'])->name('employee.get');
Route::get('/locker-status/data', [LockerStatusController::class, 'getLockerData'])->name('locker.status');
Route::get('/employees', function () {
    return Employee::select('nik as nik', 'name as name', 'department as dept')->get();
});