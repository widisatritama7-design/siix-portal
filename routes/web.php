<?php

use App\Http\Controllers\DCC\InboxController;
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
    // Inbox
    Route::view('/inbox', 'home.inbox.index')->name('inbox');
    Route::get('/inbox/dcc/waiting-receive', [InboxController::class, 'waitingReceive'])->name('inbox.dcc.waiting-receive');
    Route::get('/inbox/dcc/waiting-distribute', [InboxController::class, 'waitingDistribute'])->name('inbox.dcc.waiting-distribute');
    Route::patch('/submissions/{id}/receive', [InboxController::class, 'receive'])->name('submissions.receive');
    Route::get('/get-submission/{id}', [InboxController::class, 'getSubmission'])->name('get-submission');
    Route::post('/distribute/{id}', [InboxController::class, 'distribute'])->name('distribute');
    // User And Role
    Route::get('/users', UserManagement::class)->name('users');
    Route::get('/roles', RoleManagement::class)->name('role.management');
    Route::get('/permissions', PermissionManagement::class)->name('permission.management');
    // DCC
    Route::get('/dcc/departments', DepartmentManagement::class)->name('dcc.departments');
    Route::get('/dcc/submissions', SubmissionManagement::class)->name('dcc.submissions');
});

require __DIR__.'/settings.php';