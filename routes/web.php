<?php

use App\Helpers\QRCodeHelper;
use App\Http\Controllers\Api\ApiLockerController;
use App\Http\Controllers\Api\EspController;
use App\Http\Controllers\DashboardRefreshController;
use App\Http\Controllers\DoorLockController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\PROD\Absence\AbsenceControlPrintController;
use App\Http\Controllers\PROD\Absence\AbsenceReportPrintController;
use App\Http\Controllers\PROD\FCT\LeaderController;
use App\Http\Controllers\PROD\FCT\ScanPcbController;
use App\Http\Controllers\PROD\Uniform\UniformRequestPrintController;
use App\Http\Controllers\QAQC\NCPPrintController;
use App\Http\Controllers\SearchController;
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
use App\Livewire\PROD\Absence\AbsenceControlGenerate;
use App\Livewire\PROD\Absence\AbsenceControlIndex;
use App\Livewire\PROD\Absence\AbsenceDashboard;
use App\Livewire\PROD\Absence\AbsenceReportForm;
use App\Livewire\PROD\Absence\AbsenceReportIndex;
use App\Livewire\PROD\Absence\AbsenceReportShow;
use App\Livewire\PROD\FCT\FctScanner;
use App\Livewire\PROD\FCT\LeaderPanel;
use App\Livewire\PROD\FCT\LedTestScanner;
use App\Livewire\PROD\FCT\VisualScanner;
use App\Livewire\PROD\Kaizen\KaizenManagement;
use App\Livewire\PROD\MS\Rack\MasterRackSampleCreate;
use App\Livewire\PROD\MS\Rack\MasterRackSampleManagement;
use App\Livewire\PROD\MS\Sample\MasterSampleDashboard;
use App\Livewire\PROD\MS\Sample\MasterSampleExpiredForm;
use App\Livewire\PROD\MS\Sample\MasterSampleLoanForm;
use App\Livewire\PROD\MS\Sample\MasterSampleManagement;
use App\Livewire\PROD\MS\Sample\MasterSampleShow;
use App\Livewire\PROD\MS\Sample\SampleChecksManagement;
use App\Livewire\PROD\Uniform\MasterUniformManagement;
use App\Livewire\PROD\Uniform\UniformRequestForm;
use App\Livewire\PROD\Uniform\UniformRequestIndex;
use App\Livewire\PROD\Uniform\UniformRequestShow;
use App\Livewire\PROD\Uniform\UniformStockManagement;
use App\Livewire\PROD\Uniform\UniformStockTransactionIndex;
use App\Livewire\PROD\WIP\AddColumn;
use App\Livewire\PROD\WIP\AddSheet;
use App\Livewire\PROD\WIP\HistoryWipTransaction;
use App\Livewire\PROD\WIP\MasterModelManagement;
use App\Livewire\PROD\WIP\MasterRackLosePack;
use App\Livewire\PROD\WIP\MasterWipDetail;
use App\Livewire\PROD\WIP\MasterWipManagement;
use App\Livewire\PROD\WIP\MasterWipScan;
use App\Livewire\QAQC\NCPManagement;
use App\Livewire\QAQC\NCPReport;
use App\Livewire\Ticket\CategoryTicketManager;
use App\Livewire\Ticket\TicketManager;
use App\Livewire\Ticket\TicketView;
use App\Livewire\User\Permission\PermissionManagement;
use App\Livewire\User\Role\RoleManagement;
use App\Livewire\User\UserManagement;
use App\Models\ESD\Locker\UniformTransaction;
use App\Services\MicrosoftGraphService;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // Search
    Route::get('/search/type', [SearchController::class, 'searchEquipmentGrounds'])->name('search.equipment-grounds');

    // Dashboard
    Route::view('main-dashboard', 'home.dashboard')->name('dashboard');
    Route::get('/dashboard/refresh', [DashboardRefreshController::class, 'refresh']);
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
    Route::get('/employee-call/download-template-excel', [EmployeeCallManagement::class, 'downloadTemplate'])->name('employee-call.download-template-excel');
    Route::get('/employee-call/download-template-csv', [EmployeeCallManagement::class, 'downloadTemplateCSV'])->name('employee-call.download-template-csv');

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
    Route::get('/prod/wip/check-rack/{model}', [MasterWipManagement::class, 'checkWipInRackByModel']);
    Route::get('/prod/history', HistoryWipTransaction::class)->name('prod.history');
    Route::get('/prod/rack-lose', MasterRackLosePack::class)->name('prod.rack-lose');
    Route::get('/prod/add-sheet', AddSheet::class)->name('prod.wip.add-sheet');
    Route::get('/prod/add-column', AddColumn::class)->name('prod.wip.add-column');

    // Master Sample
    Route::get('/prod/ms/dashboard', MasterSampleDashboard::class)->name('prod.ms.dashboard');
    Route::get('/prod/ms/sample-checks', SampleChecksManagement::class)->name('prod.ms.sample-checks');
    Route::get('/prod/ms/master-sample', MasterSampleManagement::class)->name('prod.ms.master-sample');
    Route::get('/prod/ms/master-sample/{id}/{tab?}', MasterSampleShow::class)->name('prod.ms.master-sample.show');
    Route::get('/prod/ms/master-sample/{sampleId}/loan/create', MasterSampleLoanForm::class)->name('prod.ms.master-sample.loan.create');
    Route::get('/prod/ms/master-sample/{sampleId}/loan/{id}/edit', MasterSampleLoanForm::class)->name('prod.ms.master-sample.loan.edit');
    Route::get('/prod/ms/master-sample/{sampleId}/expired/create', MasterSampleExpiredForm::class)->name('prod.ms.master-sample.expired.create');
    Route::get('/prod/ms/master-sample/{sampleId}/expired/{id}/edit', MasterSampleExpiredForm::class)->name('prod.ms.master-sample.expired.edit');
    Route::get('/prod/master-sample/print/{idsParam}', function ($idsParam) {
        $idsArray = explode(',', $idsParam);
        $records = App\Models\PROD\MS\MasterSample::whereIn('id', $idsArray)->get();
        
        return view('livewire.prod.ms.sample.master-sample-bulk-print', compact('records'));
    })->name('prod.ms.master-sample.print');

    // Master Rack Sample
    Route::get('/prod/ms/master-rack', MasterRackSampleManagement::class)->name('prod.ms.master-rack');
    Route::get('/prod/ms/master-rack/create', MasterRackSampleCreate::class)->name('prod.ms.master-rack.create');

    // QA-QC
    Route::get('/qaqc/ncp', NCPManagement::class)->name('qaqc.ncp');
    Route::get('/qaqc/ncp/report', NCPReport::class)->name('qaqc.ncp.report');
    Route::get('/ncp/print/{id}', [NCPPrintController::class, 'print'])->name('ncp.print');

    // Doorlock
    Route::get('/doorlock/test-pin/{deviceId}', [DoorLockController::class, 'generatePin']);

    // Uniform
    Route::get('/hr/uniform/master', MasterUniformManagement::class)->name('prod.uniform.master');
    Route::get('/hr/uniform/request', UniformRequestIndex::class)->name('prod.uniform.request.index');
    Route::get('/hr/uniform/request/create', UniformRequestForm::class)->name('prod.uniform.request.create');
    Route::get('/hr/uniform/request/edit/{id}', UniformRequestForm::class)->name('prod.uniform.request.edit');
    Route::get('/hr/uniform/request/show/{id}', UniformRequestShow::class)->name('prod.uniform.request.show');
    Route::get('/hr/uniform/request/print/{id}', [UniformRequestPrintController::class, 'print'])->name('prod.uniform.request.print');
    Route::get('/hr/uniform/stock/manage', UniformStockManagement::class)->name('prod.uniform.stock.manage');
    Route::get('/hr/uniform/stock/transactions', UniformStockTransactionIndex::class)->name('prod.uniform.stock.transactions');

    // Absence
    Route::get('/hr/attendance/report', AbsenceReportIndex::class)->name('prod.absence.report.index');
    Route::get('/hr/attendance/report/create', AbsenceReportForm::class)->name('prod.absence.report.create');
    Route::get('/hr/attendance/report/edit/{id}', AbsenceReportForm::class)->name('prod.absence.report.edit');
    Route::get('/hr/attendance/report/show/{id}', AbsenceReportShow::class)->name('prod.absence.report.show');
    Route::get('/hr/attendance/report/print/{id}', [AbsenceReportPrintController::class, 'print'])->name('prod.absence.report.print');
    Route::get('/hr/attendance/control', AbsenceControlIndex::class)->name('prod.absence.control');
    Route::get('/hr/attendance/control/generate', AbsenceControlGenerate::class)->name('prod.absence.control.generate');
    Route::get('/hr/attendance/control/print/{startDate}/{endDate}/{department?}/{group?}', [AbsenceControlPrintController::class, 'print'])->name('prod.absence.control.print');
    Route::get('/hr/attendance/dashboard', AbsenceDashboard::class)->name('prod.absence.dashboard');

    // FCT
    Route::get('/pcb-scan/fct', FctScanner::class)->name('pcb-scan.fct');
    Route::get('/pcb-scan/led-test', LedTestScanner::class)->name('pcb-scan.led-test');
    Route::get('/pcb-scan/visual-inspection', VisualScanner::class)->name('pcb-scan.visual-inspection');
    Route::get('/pcb-scan/leader', LeaderPanel::class)->name('pcb-scan.leader.index');
    Route::get('/pcb-scan', [ScanPcbController::class, 'index'])->name('pcb-scan.dashboard');
    Route::post('/pcb-scan/process/{process}', [ScanPcbController::class, 'processScan'])->name('pcb-scan.process');
    Route::get('/pcb-scan/leader/unlock/{id}', [LeaderController::class, 'showUnlockForm'])->name('pcb-scan.leader.unlock.form');
    Route::post('/pcb-scan/leader/unlock/{id}', [LeaderController::class, 'unlock'])->name('pcb-scan.leader.unlock');
    Route::get('/pcb-scan/leader/settings', [LeaderController::class, 'settings'])->name('pcb-scan.leader.settings');
    Route::post('/pcb-scan/leader/generate-code', [LeaderController::class, 'generateCode'])->name('pcb-scan.leader.generate-code');
    Route::post('/pcb-scan/leader/store', [LeaderController::class, 'storeLeader'])->name('pcb-scan.leader.store');
    Route::put('/pcb-scan/leader/update/{id}', [LeaderController::class, 'updateLeader'])->name('pcb-scan.leader.update');
    Route::prefix('api')->group(function () {
        Route::get('/check-system-lock', [ScanPcbController::class, 'checkSystemLock']);
        Route::get('/recent-scans/{process}', [ScanPcbController::class, 'getRecentScans']);
        Route::get('/today-stats/{process}', [ScanPcbController::class, 'getTodayStats']);
        Route::get('/visual-inspection-stats', [ScanPcbController::class, 'getVisualStats']);
        Route::get('/dashboard-stats', [ScanPcbController::class, 'getDashboardStats']);
    });
});

Route::get('/test-microsoft', function (MicrosoftGraphService $graph) {
    $token = $graph->getAccessToken();

    return response()->json([
        'success' => true,
        'message' => 'Microsoft Graph authentication berhasil!',
        'token_received' => !empty($token),
    ]);
});

Route::get('/test-microsoft-email', function (MicrosoftGraphService $graph) {

    $graph->sendEmail(
        'sek.esd@siix-global.com',
        'Test Microsoft Graph - Laravel',
        '
        <h2>Test Email</h2>
        <p>Email ini dikirim dari Laravel menggunakan Microsoft Graph API.</p>
        <p><strong>Sender:</strong> sek.apps-notification@siix-global.com</p>
        <p>Jika email ini diterima, berarti integrasi Microsoft Graph sudah berhasil.</p>
        '
    );

    return response()->json([
        'success' => true,
        'message' => 'Email berhasil dikirim.'
    ]);
});

Route::get('/test-microsoft-sender', function (MicrosoftGraphService $graph) {

    $response = $graph->testSender();

    return response()->json([
        'status' => $response->status(),
        'body' => $response->json(),
    ]);
});

Route::get('/test-whatsapp', function (
    WhatsAppService $whatsapp
) {

    return $whatsapp->send(
        '6289529070107',
        'Halo, ini pesan dari Laravel SIIX EMS.'
    );

});

Route::get('/qr-scan/{accessCode}', function ($accessCode) {
    $transaction = UniformTransaction::where('access_code', $accessCode)
        ->whereIn('status', ['pending', 'waiting_pickup'])
        ->where('expires_at', '>', now())
        ->first();
    
    if (!$transaction) {
        return redirect('/esd/locker-info')->with('error', 'QR Code tidak valid atau sudah kadaluarsa!');
    }
    
    // Redirect ke halaman locker info dengan access code
    return redirect('/esd/locker-info?take_code=' . $accessCode);
})->name('qr-scan');

Route::get('/test-whatsapp-qr', function (WhatsAppService $whatsapp) {
    // Generate QR Code test
    $qrData = [
        'action' => 'test',
        'access_code' => 'TEST123',
        'locker_code' => 'TEST001',
        'employee_name' => 'Test User',
        'nik' => '123456',
        'expires_at' => now()->addHours(24)->format('Y-m-d H:i:s')
    ];
    
    $qrPath = QRCodeHelper::generateAndSave('TEST123', $qrData);
    
    if (!$qrPath) {
        return response()->json(['error' => 'QR Code generation failed'], 500);
    }
    
    $message = "🏢 *ESD Locker System*\n\n";
    $message .= "Halo *Test User*,\n\n";
    $message .= "✅ Test QR Code\n\n";
    $message .= "📱 *Scan QR Code di bawah:*\n\n";
    $message .= "⚠️ Test message";
    
    try {
        $result = $whatsapp->sendWithQRImage('6287883994150', $message, $qrPath);
        return response()->json([
            'success' => true,
            'result' => $result,
            'qr_path' => $qrPath
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'qr_path' => $qrPath
        ], 500);
    }
});

// Halaman
Route::get('/esd-locker', function () {
    return view('esd.locker.index');
})->name('esd.locker');

// Route untuk ESP32
Route::prefix('esp')->group(function () {
    // Heartbeat - diterima dari ESP32
    Route::post('/heartbeat', [EspController::class, 'heartbeat']);
    
    // Ambil data device (untuk dashboard)
    Route::get('/devices', [EspController::class, 'index']);
    Route::get('/devices/{deviceId}', [EspController::class, 'show']);
    Route::get('/devices/{deviceId}/logs', [EspController::class, 'logs']);
});

// ESP32 Locker API - Tanpa prefix api
Route::prefix('lockers')->group(function () {
    // ESP32 membaca status - hanya kirim should_open (true/false)
    Route::get('/status', [ApiLockerController::class, 'getStatus']);
    
    // ESP32 melaporkan status
    Route::match(['get', 'post'], '/open', [ApiLockerController::class, 'reportOpen']);
    Route::match(['get', 'post'], '/open/{code}', [ApiLockerController::class, 'reportOpen']);
    Route::match(['get', 'post'], '/close', [ApiLockerController::class, 'reportClose']);
    Route::match(['get', 'post'], '/close/{code}', [ApiLockerController::class, 'reportClose']);
    
    // Ping untuk cek koneksi
    Route::get('/ping', [ApiLockerController::class, 'ping']);
});

require __DIR__.'/settings.php';
require __DIR__.'/esd.php';
require __DIR__.'/mtc.php';