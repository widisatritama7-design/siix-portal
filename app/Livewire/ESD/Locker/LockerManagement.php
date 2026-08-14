<?php

namespace App\Livewire\ESD\Locker;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Locker\Locker;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use Illuminate\Support\Facades\DB;

class LockerManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $locker_id;
    public $code;
    public $status;
    public $employee_id;
    public $modalTitle = 'Add New Locker';
    public $lockerToDelete = null;
    public $showDetail = false;
    public $selectedLocker = null;
    
    // For transaction pagination in detail modal
    public $transactionPage = 1;
    public $perPage = 5;

    // For take locker with access code
    public $showTakeModal = false;
    public $takeLockerId = null;
    public $takeAccessCode = '';

    // For teknisi take
    public $teknisiNik = '';
    public $teknisiEmployee = null;
    public $teknisiTransaction = null;
    public $teknisiStep = 1;
    public $teknisiIsLoading = false;

    // For teknisi return
    public $returnAccessCode = '';
    public $returnTransaction = null;
    public $returnStep = 1;
    public $returnIsLoading = false;

    // Tambahkan property ini di bagian atas
    public $ngAccessCode = '';
    public $ngLockerData = null;
    public $ngReason = '';
    public $ngStep = 1;

    // Property baru untuk take dengan access code
    public $teknisiTakeAccessCode = '';
    public $teknisiTakeTransaction = null;
    public $teknisiTakeStep = 1;
    public $teknisiTakeIsLoading = false;

    protected function rules()
    {
        return [
            'code' => 'required|string|max:10|unique:tb_esd_lockers,code,' . $this->locker_id,
            'status' => 'required|in:available,open,in_progress,ng,finished',
        ];
    }

    protected $messages = [
        'code.required' => 'Locker code is required.',
        'code.unique' => 'This locker code already exists.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be available, open, in_progress, ng, or finished.',
    ];

    public function resetForm()
    {
        $this->reset(['locker_id', 'code', 'status', 'employee_id']);
        $this->modalTitle = 'Add New Locker';
        $this->resetValidation();
    }

    // Tambahkan di controller LockerManagement

    public function printThermal($transactionId)
    {
        $transaction = UniformTransaction::with(['employee', 'locker'])->find($transactionId);
        
        if (!$transaction) {
            abort(404, 'Transaction not found');
        }
        
        return redirect()->route('esd.print-label-thermal', ['transactionId' => $transactionId]);
    }

    public function updatedSearch()
    {
        // No need to reset page since we're not using pagination for lockers
    }

    public function updatedStatusFilter()
    {
        // No need to reset page since we're not using pagination for lockers
    }

    public function resetTeknisiTakeForm()
    {
        $this->reset(['teknisiTakeAccessCode', 'teknisiTakeTransaction', 'teknisiTakeStep']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function teknisiTakeCheckCode()
    {
        $this->validate([
            'teknisiTakeAccessCode' => 'required|string|max:50'
        ], [
            'teknisiTakeAccessCode.required' => 'Access code is required!'
        ]);

        // Cari transaksi dengan status pending
        $this->teknisiTakeTransaction = UniformTransaction::where('access_code', $this->teknisiTakeAccessCode)
            ->where('status', 'pending')
            ->whereHas('locker', function($query) {
                $query->where('status', 'open');
            })
            ->with(['employee', 'locker'])
            ->first();

        if (!$this->teknisiTakeTransaction) {
            $this->dispatch('notify', message: 'Invalid access code or uniform already taken!', type: 'error');
            return;
        }

        $this->teknisiTakeStep = 2;
    }

    public function teknisiTakePrintLabel()
    {
        $this->teknisiTakeIsLoading = true;

        DB::transaction(function () {
            // Update status transaksi menjadi on_progress
            $this->teknisiTakeTransaction->update([
                'status' => 'on_progress',
                'taken_at' => now()
            ]);

            // Update locker status menjadi 'in_progress'
            $this->teknisiTakeTransaction->locker->update([
                'status' => 'in_progress',
                'locked_until' => now()->addSeconds(15)
            ]);

            // Kirim notifikasi WhatsApp ke user
            $this->sendTeknisiTakeWhatsAppNotification(
                $this->teknisiTakeTransaction->employee,
                "Hello {$this->teknisiTakeTransaction->employee->name}, your uniform is being checked (On Progress Measure)"
            );

            $this->dispatch('notify', message: 'Label printed successfully! Status changed to In Progress.', type: 'success');
        });

        $this->teknisiTakeIsLoading = false;
        $this->teknisiTakeStep = 3;
    }

    public function teknisiTakeScanAndOpen()
    {
        $this->teknisiTakeIsLoading = true;

        DB::transaction(function () {
            $locker = $this->teknisiTakeTransaction->locker;

            // Update locker - buka loker, status tetap in_progress
            $locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            // Dispatch event buka loker
            $this->dispatch('open-locker', ['code' => $locker->code]);

            $this->teknisiTakeStep = 4;
            $this->dispatch('notify', message: 'Locker opened successfully! Take the uniform for checking.', type: 'success');
        });

        $this->teknisiTakeIsLoading = false;
    }

    protected function sendTeknisiTakeWhatsAppNotification($employee, $message)
    {
        try {
            \Log::info('WhatsApp notification sent to: ' . $employee->nik, ['message' => $message]);
        } catch (\Exception $e) {
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
    }

    // ============ NG (Reject Locker) ============

    // Tambahkan method ini
    public function resetNgForm()
    {
        $this->reset(['ngAccessCode', 'ngLockerData', 'ngReason', 'ngStep']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function ngCheckCode()
    {
        $this->validate([
            'ngAccessCode' => 'required|string|max:50'
        ], [
            'ngAccessCode.required' => 'Access code is required!'
        ]);

        // Cari transaksi dengan status on_progress
        $transaction = UniformTransaction::where('access_code', $this->ngAccessCode)
            ->where('status', 'on_progress')
            ->with(['employee', 'locker'])
            ->first();

        if (!$transaction) {
            $this->dispatch('notify', message: 'Invalid access code or not in progress!', type: 'error');
            return;
        }

        $this->ngLockerData = $transaction->locker;
        $this->ngStep = 2;
    }

    public function ngConfirm()
    {
        if (!$this->ngLockerData) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        DB::transaction(function () {
            // Update locker status menjadi NG
            $this->ngLockerData->update([
                'status' => 'ng'
            ]);

            // Update transaction terakhir yang terkait dengan locker ini
            $transaction = UniformTransaction::where('locker_id', $this->ngLockerData->id)
                ->where('status', 'on_progress')
                ->latest()
                ->first();

            if ($transaction) {
                $transaction->update([
                    'status' => 'ng',
                    'notes' => $this->ngReason ?? 'Marked as NG by technician'
                ]);
            }

            // Log untuk audit
            \Log::info('Locker marked as NG', [
                'locker_id' => $this->ngLockerData->id,
                'locker_code' => $this->ngLockerData->code,
                'reason' => $this->ngReason,
                'by' => auth()->user()->name ?? 'System'
            ]);

            $this->ngStep = 3;
            $this->dispatch('notify', message: "Locker {$this->ngLockerData->code} marked as NG successfully!", type: 'warning');
        });
    }
    
    public function openNgModal($id)
    {
        $locker = Locker::find($id);
        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        if ($locker->status !== 'in_progress') {
            $this->dispatch('notify', message: 'Only In Progress lockers can be marked as NG!', type: 'error');
            return;
        }

        $this->ngLocker = $locker;
        $this->ngReason = '';
        $this->dispatch('open-modal', 'ng-locker-modal');
    }

    public function confirmNg()
    {
        if (!$this->ngLocker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        DB::transaction(function () {
            // Update locker status menjadi NG
            $this->ngLocker->update([
                'status' => 'ng'
            ]);

            // Update transaction terakhir yang terkait dengan locker ini
            $transaction = UniformTransaction::where('locker_id', $this->ngLocker->id)
                ->where('status', 'on_progress')
                ->latest()
                ->first();

            if ($transaction) {
                $transaction->update([
                    'status' => 'ng',
                    'notes' => $this->ngReason ?? 'Marked as NG by technician'
                ]);
            }

            // Log untuk audit
            \Log::info('Locker marked as NG', [
                'locker_id' => $this->ngLocker->id,
                'locker_code' => $this->ngLocker->code,
                'reason' => $this->ngReason,
                'by' => auth()->user()->name ?? 'System'
            ]);

            $this->dispatch('notify', message: "Locker {$this->ngLocker->code} marked as NG successfully!", type: 'warning');
        });

        $this->ngLocker = null;
        $this->ngReason = '';
        $this->dispatch('close-modal', 'ng-locker-modal');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'code' => $this->code,
            'status' => $this->status ?? 'available',
        ];

        if ($this->locker_id) {
            $locker = Locker::find($this->locker_id);
            if (!$locker) {
                $this->dispatch('notify', message: 'Locker not found!', type: 'error');
                return;
            }
            $locker->update($data);
            $message = 'Locker updated successfully!';
        } else {
            Locker::create($data);
            $message = 'Locker created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'locker-form-modal');
    }

    public function edit($id)
    {
        $locker = Locker::find($id);

        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        $this->locker_id = $locker->id;
        $this->code = $locker->code;
        $this->status = $locker->status;
        $this->employee_id = $locker->employee_id;
        $this->modalTitle = 'Edit Locker';
    }

    public function viewDetail($id)
    {
        // Load locker with employee
        $this->selectedLocker = Locker::with('employee')->find($id);

        if (!$this->selectedLocker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        // Reset transaction page to 1 when opening detail
        $this->transactionPage = 1;
        $this->showDetail = true;
        $this->dispatch('open-modal', 'locker-detail-modal');
    }

    // ============ ACTION FOR TECHNICIAN ============
    
    // Open modal untuk mengambil locker (open -> in_progress)
    public function openTakeModal($id)
    {
        $locker = Locker::find($id);
        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        if ($locker->status !== 'open') {
            $this->dispatch('notify', message: 'Locker must be open to be taken!', type: 'error');
            return;
        }

        $this->takeLockerId = $id;
        $this->takeAccessCode = '';
        $this->showTakeModal = true;
        $this->dispatch('open-modal', 'take-locker-modal');
    }

    // Proses take locker dengan kode akses
    public function takeLockerWithCode()
    {
        $this->validate([
            'takeAccessCode' => 'required|string|max:50'
        ], [
            'takeAccessCode.required' => 'Access code is required!'
        ]);

        $locker = Locker::find($this->takeLockerId);
        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        // Cek apakah ada transaksi dengan kode akses yang valid
        $transaction = UniformTransaction::where('access_code', $this->takeAccessCode)
            ->where('locker_id', $locker->id)
            ->whereIn('status', ['pending', 'waiting_pickup'])
            ->where('expires_at', '>', now())
            ->first();

        if (!$transaction) {
            $this->dispatch('notify', message: 'Invalid access code or transaction expired!', type: 'error');
            return;
        }

        // Update status locker menjadi in_progress
        $locker->markAsInProgress();
        
        // Update transaction status
        $transaction->update([
            'status' => 'on_progress'
        ]);

        $this->showTakeModal = false;
        $this->takeLockerId = null;
        $this->takeAccessCode = '';
        $this->dispatch('close-modal', 'take-locker-modal');
        $this->dispatch('notify', message: 'Locker taken successfully! Now in progress.');
    }

    // Hapus method ini atau ubah menjadi:
    public function rejectLocker($id)
    {
        return $this->openNgModal($id);
    }

    // Action: Teknisi selesai (in_progress atau ng -> finished)
    public function finishLocker($id)
    {
        $locker = Locker::find($id);
        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        // Bisa dari in_progress atau ng ke finished
        if (!in_array($locker->status, ['in_progress', 'ng'])) {
            $this->dispatch('notify', message: 'Locker must be in progress or NG to be finished!', type: 'error');
            return;
        }

        $locker->markAsFinished();
        $this->dispatch('notify', message: 'Locker work completed!');
    }

    // Action: Kembalikan locker ke available (finished -> available)
    public function resetLocker($id)
    {
        $locker = Locker::find($id);
        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        // Hanya finished yang bisa direset ke available
        if ($locker->status !== 'finished') {
            $this->dispatch('notify', message: 'Only Finished lockers can be reset to available!', type: 'error');
            return;
        }

        $locker->markAsAvailable();
        $this->dispatch('notify', message: 'Locker reset to available!');
    }

    // ============ TEKNISI TAKE ============
    
    public function resetTeknisiForm()
    {
        $this->reset(['teknisiNik', 'teknisiEmployee', 'teknisiTransaction', 'teknisiStep']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function teknisiSearchEmployee()
    {
        $this->validate([
            'teknisiNik' => 'required|string|max:20|exists:tb_hr_employee,nik'
        ], [
            'teknisiNik.required' => 'NIK is required',
            'teknisiNik.exists' => 'NIK not found in database'
        ]);

        $this->teknisiEmployee = Employee::where('nik', $this->teknisiNik)->first();

        if (!$this->teknisiEmployee) {
            $this->dispatch('notify', message: 'Employee data not found!', type: 'error');
            return;
        }

        // Cek apakah ada transaksi dengan status pending dan locker status 'open'
        $this->teknisiTransaction = UniformTransaction::where('employee_id', $this->teknisiEmployee->id)
            ->where('status', 'pending')
            ->whereHas('locker', function($query) {
                $query->where('status', 'open');
            })
            ->latest()
            ->first();

        if (!$this->teknisiTransaction) {
            $this->dispatch('notify', message: 'No uniform needs to be checked for this employee!', type: 'error');
            return;
        }

        $this->teknisiStep = 2;
    }

    public function teknisiPrintLabel()
    {
        $this->teknisiIsLoading = true;

        DB::transaction(function () {
            // Update status transaksi menjadi on_progress
            $this->teknisiTransaction->update([
                'status' => 'on_progress',
                'taken_at' => now()
            ]);

            // Update locker status menjadi 'in_progress'
            $this->teknisiTransaction->locker->update([
                'status' => 'in_progress',
                'locked_until' => now()->addSeconds(15)
            ]);

            // Kirim notifikasi WhatsApp ke user
            $this->sendTeknisiWhatsAppNotification(
                $this->teknisiEmployee,
                "Hello {$this->teknisiEmployee->name}, your uniform is being checked (On Progress Measure)"
            );

            $this->dispatch('notify', message: 'Label printed successfully! Status changed to In Progress.', type: 'success');
        });

        $this->teknisiIsLoading = false;
        $this->teknisiStep = 3;
    }

    public function teknisiScanAndOpen()
    {
        $this->teknisiIsLoading = true;

        DB::transaction(function () {
            $locker = $this->teknisiTransaction->locker;

            // Update locker - buka loker, status tetap in_progress
            $locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            // Dispatch event buka loker
            $this->dispatch('open-locker', ['code' => $locker->code]);

            $this->teknisiStep = 4;
            $this->dispatch('notify', message: 'Locker opened successfully! Take the uniform for checking.', type: 'success');
        });

        $this->teknisiIsLoading = false;
    }

    protected function sendTeknisiWhatsAppNotification($employee, $message)
    {
        try {
            \Log::info('WhatsApp notification sent to: ' . $employee->nik, ['message' => $message]);
        } catch (\Exception $e) {
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
    }

    // ============ TEKNISI RETURN ============
        
    public function resetReturnForm()
    {
        $this->reset(['returnAccessCode', 'returnTransaction', 'returnStep']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function returnCheckCode()
    {
        $this->validate([
            'returnAccessCode' => 'required|string|max:50'
        ], [
            'returnAccessCode.required' => 'Access code is required!'
        ]);

        // Cari transaksi dengan status on_progress ATAU ng
        $this->returnTransaction = UniformTransaction::where('access_code', $this->returnAccessCode)
            ->whereIn('status', ['on_progress', 'ng'])
            ->with(['employee', 'locker'])
            ->first();

        if (!$this->returnTransaction) {
            $this->dispatch('notify', message: 'Invalid access code or not in checking process!', type: 'error');
            return;
        }

        $this->returnStep = 2;
    }

    public function returnUniform()
    {
        $this->returnIsLoading = true;

        DB::transaction(function () {
            $locker = $this->returnTransaction->locker;

            // Buka loker
            $locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            // Update transaksi menjadi waiting_pickup (menunggu diambil user)
            $this->returnTransaction->update([
                'status' => 'waiting_pickup',
                'stored_at' => now()
            ]);

            // Update locker status menjadi 'finished' (selesai dicek)
            $locker->update([
                'status' => 'finished'
            ]);

            // Dispatch event buka loker
            $this->dispatch('open-locker', ['code' => $locker->code]);

            // Kirim notifikasi WhatsApp ke user
            $this->sendReturnWhatsAppNotification(
                $this->returnTransaction->employee,
                "Hello {$this->returnTransaction->employee->name}, your uniform has been checked and finished. Please take it immediately."
            );

            $this->returnStep = 3;
            $this->dispatch('notify', message: 'Locker opened successfully! Uniform has been returned and marked as Finished.', type: 'success');
        });

        $this->returnIsLoading = false;
    }

    protected function sendReturnWhatsAppNotification($employee, $message)
    {
        try {
            \Log::info('WhatsApp notification sent to: ' . $employee->nik, ['message' => $message]);
        } catch (\Exception $e) {
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
    }

    // ============ DELETE ============
    
    public function confirmDelete($id)
    {
        $locker = Locker::find($id);

        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        // Cek apakah locker sedang diproses
        if (in_array($locker->status, ['open', 'in_progress'])) {
            $this->dispatch('notify', message: 'Cannot delete locker that is currently in use!', type: 'error');
            return;
        }

        $this->lockerToDelete = $locker;
        $this->dispatch('open-modal', 'delete-locker-modal');
    }

    public function delete()
    {
        $locker = Locker::find($this->lockerToDelete->id);

        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            $this->lockerToDelete = null;
            return;
        }

        $code = $locker->code;
        $locker->delete();

        $this->lockerToDelete = null;
        $this->dispatch('notify', message: "Locker '{$code}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-locker-modal');
    }

    public function cancelDelete()
    {
        $this->lockerToDelete = null;
        $this->dispatch('close-modal', 'delete-locker-modal');
    }

    public function updatedTransactionPage()
    {
        // This will trigger re-render when transaction page changes
    }

    public function getTransactionsProperty()
    {
        if (!$this->selectedLocker) {
            return collect();
        }

        return $this->selectedLocker->transactions()
            ->with('employee')
            ->latest()
            ->paginate($this->perPage, ['*'], 'transactionPage', $this->transactionPage);
    }

    public function render()
    {
        $lockers = Locker::with('employee')
            ->when($this->search, function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('id')
            ->get();

        $stats = [
            'total' => Locker::count(),
            'available' => Locker::available()->count(),
            'open' => Locker::open()->count(),
            'in_progress' => Locker::inProgress()->count(),
            'ng' => Locker::ng()->count(),
            'finished' => Locker::finished()->count(),
            'transactions_active' => UniformTransaction::whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])->count()
        ];

        return view('livewire.esd.locker.locker-management', [
            'lockers' => $lockers,
            'stats' => $stats,
            'transactions' => $this->getTransactionsProperty()
        ]);
    }
}