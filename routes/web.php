<?php

use App\Http\Controllers\InboxController;
use App\Livewire\DCC\DepartmentManagement;
use App\Livewire\DCC\SubmissionManagement;
use App\Livewire\HR\ComelateEmployee\ComelateEmployeeCreate;
use App\Livewire\HR\ComelateEmployee\ComelateEmployeeEdit;
use App\Livewire\HR\ComelateEmployee\ComelateEmployeeManagement;
use App\Livewire\HR\ComelateEmployee\ComelateReport;
use App\Livewire\HR\EmployeeCallManagement;
use App\Livewire\HR\EmployeeManagement;
use App\Livewire\HR\Violation\ViolationEmployeeCreate;
use App\Livewire\HR\Violation\ViolationEmployeeEdit;
use App\Livewire\HR\Violation\ViolationEmployeeManagement;
use App\Livewire\HR\Violation\ViolationReport;
use App\Livewire\NotificationManager;
use App\Livewire\PROD\Kaizen\KaizenManagement;
use App\Livewire\PROD\MS\Rack\MasterRackSampleCreate;
use App\Livewire\PROD\MS\Rack\MasterRackSampleManagement;
use App\Livewire\PROD\MS\Sample\MasterSampleDashboard;
use App\Livewire\PROD\MS\Sample\MasterSampleExpiredForm;
use App\Livewire\PROD\MS\Sample\MasterSampleLoanForm;
use App\Livewire\PROD\MS\Sample\MasterSampleManagement;
use App\Livewire\PROD\MS\Sample\MasterSampleShow;
use App\Livewire\PROD\WIP\HistoryWipTransaction;
use App\Livewire\PROD\WIP\MasterModelManagement;
use App\Livewire\PROD\WIP\MasterRackLosePack;
use App\Livewire\PROD\WIP\MasterWipDetail;
use App\Livewire\PROD\WIP\MasterWipManagement;
use App\Livewire\PROD\WIP\MasterWipScan;
use App\Livewire\Ticket\CategoryTicketManager;
use App\Livewire\Ticket\TicketManager;
use App\Livewire\Ticket\TicketView;
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
    Route::view('hr-dashboard', 'home.hr_dashboard')->name('hr-dashboard');
    Route::view('ticket-dashboard', 'home.ticket_dashboard')->name('ticket-dashboard');
    Route::view('esd-dashboard', 'home.esd_dashboard')->name('esd-dashboard');
    Route::view('kaizen-dashboard', 'home.kaizen_dashboard')->name('kaizen-dashboard');

    // Notification
    Route::get('/notifications', NotificationManager::class)->name('notifications.manager');
    
    // Inbox
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

    // HR
    Route::get('/hr/employees', EmployeeManagement::class)->name('hr.employee');
    Route::get('/hr/comelate', ComelateEmployeeManagement::class)->name('hr.comelate.index');
    Route::get('/hr/comelate/create', ComelateEmployeeCreate::class)->name('hr.comelate.create');
    Route::get('/hr/comelate/{id}/edit', ComelateEmployeeEdit::class)->name('hr.comelate.edit');
    Route::get('/hr/comelate/report', ComelateReport::class)->name('hr.comelate.report');
    Route::get('/hr/violation', ViolationEmployeeManagement::class)->name('hr.violation.index');
    Route::get('/hr/violation/create', ViolationEmployeeCreate::class)->name('hr.violation.create');
    Route::get('/hr/violation/{id}/edit', ViolationEmployeeEdit::class)->name('hr.violation.edit');
    Route::get('/hr/violation/report', ViolationReport::class)->name('hr.violation.report');
    Route::get('/hr/employee-call', EmployeeCallManagement::class)->name('hr.employee-call.index');

    // Ticket
    Route::get('/ticket/categories', CategoryTicketManager::class)->name('ticket.categories');
    Route::get('/ticket/list', TicketManager::class)->name('ticket.list');
    Route::get('/ticket/list/{id}', TicketView::class)->name('ticket.show');

    // Kaizen
    Route::get('/prod/kaizens', KaizenManagement::class)->name('prod.kaizens');

    // Master Model
    Route::get('/prod/master-models', MasterModelManagement::class)->name('prod.master-models');

    // Master WIP
    Route::get('/prod/wip', MasterWipManagement::class)->name('prod.wip.index');
    Route::get('/prod/wip/{id}', MasterWipDetail::class)->name('prod.wip.show');
    Route::get('/prod/wip/{id}/scan', MasterWipScan::class)->name('prod.wip.scan');
    Route::get('/prod/history', HistoryWipTransaction::class)->name('prod.history');
    Route::get('/prod/rack-lose', MasterRackLosePack::class)->name('prod.rack-lose');

    // Master Sample
    Route::get('/prod/ms/dashboard', MasterSampleDashboard::class)->name('prod.ms.dashboard');
    Route::get('/prod/ms/master-sample', MasterSampleManagement::class)->name('prod.ms.master-sample');
    Route::get('/prod/ms/master-sample/{id}/{tab?}', MasterSampleShow::class)->name('prod.ms.master-sample.show');
    Route::get('/prod/ms/master-sample/{sampleId}/loan/create', MasterSampleLoanForm::class)->name('prod.ms.master-sample.loan.create');
    Route::get('/prod/ms/master-sample/{sampleId}/loan/{id}/edit', MasterSampleLoanForm::class)->name('prod.ms.master-sample.loan.edit');
    Route::get('/prod/ms/master-sample/{sampleId}/expired/create', MasterSampleExpiredForm::class)->name('prod.ms.master-sample.expired.create');
    Route::get('/prod/ms/master-sample/{sampleId}/expired/{id}/edit', MasterSampleExpiredForm::class)->name('prod.ms.master-sample.expired.edit');
    Route::get('/prod/master-sample/print/{idsParam}', function ($idsParam) {
        $idsArray = explode(',', $idsParam);
        $records = App\Models\PROD\MS\MasterSample::whereIn('id', $idsArray)->get();
        
        return view('livewire.prod.ms.master-sample-bulk-print', compact('records'));
    })->name('prod.ms.master-sample.print');

    // Master Rack Sample
    Route::get('/prod/ms/master-rack', MasterRackSampleManagement::class)->name('prod.ms.master-rack');
    Route::get('/prod/ms/master-rack/create', MasterRackSampleCreate::class)->name('prod.ms.master-rack.create');

});

require __DIR__.'/settings.php';
require __DIR__.'/esd.php';
require __DIR__.'/mtc.php';