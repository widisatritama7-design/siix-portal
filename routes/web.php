<?php

use App\Http\Controllers\InboxController;
use App\Livewire\DCC\DepartmentManagement;
use App\Livewire\DCC\SubmissionManagement;
use App\Livewire\User\Permission\PermissionManagement;
use App\Livewire\User\Role\RoleManagement;
use App\Livewire\User\UserManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::view('main-dashboard', 'home.dashboard')->name('dashboard');
    Route::view('dcc-dashboard', 'home.dcc_dashboard')->name('dcc-dashboard');
    
    // Inbox - Changed from Route::view to use controller
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox');
    Route::get('/inbox/waiting-receive', [InboxController::class, 'waitingReceive'])->name('inbox.waiting-receive');
    Route::post('/inbox/receive/{id}', [InboxController::class, 'receive'])->name('inbox.receive');
    Route::get('/inbox/waiting-distribute', [InboxController::class, 'waitingDistribute'])->name('inbox.waiting-distribute');
    Route::get('/inbox/submission/{id}', [InboxController::class, 'getSubmission'])->name('inbox.get-submission');
    Route::post('/inbox/distribute/{id}', [InboxController::class, 'distribute'])->name('inbox.distribute');
    
    // User And Role
    Route::get('/users', UserManagement::class)->name('users');
    Route::get('/roles', RoleManagement::class)->name('role.management');
    Route::get('/permissions', PermissionManagement::class)->name('permission.management');
    
    // DCC
    Route::get('/dcc/departments', DepartmentManagement::class)->name('dcc.departments');
    Route::get('/dcc/submissions', SubmissionManagement::class)->name('dcc.submissions');
});

require __DIR__.'/settings.php';