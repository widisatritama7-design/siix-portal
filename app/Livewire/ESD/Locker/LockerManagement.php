<?php

namespace App\Livewire\ESD\Locker;

use App\Helpers\QRCodeHelper;
use App\Models\ESD\Locker\Locker;
use App\Models\ESD\Locker\UniformTransaction;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

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
    
    public $transactionPage = 1;
    public $perPage = 5;

    public $showTakeModal = false;
    public $takeLockerId = null;
    public $takeAccessCode = '';

    public $teknisiNik = '';
    public $teknisiEmployee = null;
    public $teknisiTransaction = null;
    public $teknisiStep = 1;
    public $teknisiIsLoading = false;

    public $returnAccessCode = '';
    public $returnTransaction = null;
    public $returnStep = 1;
    public $returnIsLoading = false;

    public $ngAccessCode = '';
    public $ngLockerData = null;
    public $ngReason = '';
    public $ngStep = 1;

    public $teknisiTakeAccessCode = '';
    public $teknisiTakeTransaction = null;
    public $teknisiTakeStep = 1;
    public $teknisiTakeIsLoading = false;

    public $espConnected = false;
    public $lastEspUpdate = null;
    public $espChecking = false;

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

    public function checkEspStatus()
    {
        $this->espChecking = true;
        
        try {
            // Cek status ESP32 via API
            $response = Http::get('http://test.siix-ems.co.id/api/esp-status');
            
            if ($response->successful()) {
                $data = $response->json();
                $this->espConnected = $data['connected'] ?? false;
                $this->lastEspUpdate = now();
            }
        } catch (\Exception $e) {
            $this->espConnected = false;
        }
        
        $this->espChecking = false;
    }

    public function mount()
    {
        $this->checkEspStatus();
    }

    // ============ TEKNISI TAKE ============
    
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
            $this->teknisiTakeTransaction->update([
                'status' => 'on_progress',
                'taken_at' => now()
            ]);

            $locker = $this->teknisiTakeTransaction->locker;
            $locker->update([
                'status' => 'in_progress',
                'locked_until' => now()->addSeconds(15),
                'is_open' => true,
                'opened_at' => now()
            ]);

            // ============ SCHEDULE AUTO CLOSE ============
            dispatch(new \App\Jobs\AutoCloseLockerJob($locker->id))->delay(now()->addSeconds(15));
            // =============================================

            // Kirim WhatsApp
            $this->sendTeknisiTakeWhatsApp($this->teknisiTakeTransaction);

            $this->dispatch('notify', message: 'Label printed successfully! Status changed to In Progress.', type: 'success');
        });

        $this->teknisiTakeIsLoading = false;
        $this->teknisiTakeStep = 3;
    }

    protected function sendTeknisiTakeWhatsApp($transaction)
    {
        try {
            $whatsapp = app(WhatsAppService::class);
            $employee = $transaction->employee;
            
            $phone = $transaction->phone;
            
            if (!$phone) {
                Log::error('No phone number for Teknisi Take', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            $message = "*ESD Locker System*\n\n";
            $message .= "Halo *{$employee->name}*,\n\n";
            $message .= "🔄 Seragam Anda sedang dalam *proses pengecekan* (On Progress Measure)\n\n";
            $message .= "📋 *Detail:*\n";
            $message .= "• NIK: {$employee->nik}\n";
            $message .= "• Locker: {$transaction->locker->code}\n";
            $message .= "• Status: Sedang Diperiksa\n";
            $message .= "• Waktu: " . now()->format('d/m/Y H:i') . "\n\n";
            $message .= "⏳ Mohon tunggu, Anda akan mendapat notifikasi setelah seragam selesai diperiksa.\n\n";
            $message .= "Terima kasih telah menggunakan layanan ESD.\n";
            $message .= "_Pesan ini dikirim otomatis oleh sistem._";

            $whatsapp->send($phone, $message);
            
            Log::info('WhatsApp Teknisi Take sent successfully', [
                'transaction_id' => $transaction->id,
                'phone' => $phone
            ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp Teknisi Take send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }

    public function teknisiTakeScanAndOpen()
    {
        $this->teknisiTakeIsLoading = true;

        DB::transaction(function () {
            $locker = $this->teknisiTakeTransaction->locker;

            $locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            $this->dispatch('open-locker', ['code' => $locker->code]);

            $this->teknisiTakeStep = 4;
            $this->dispatch('notify', message: 'Locker opened successfully! Take the uniform for checking.', type: 'success');
        });

        $this->teknisiTakeIsLoading = false;
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

            $locker->update([
                'locked_until' => now()->addSeconds(15),
                'is_open' => true,
                'opened_at' => now()
            ]);

            $this->returnTransaction->update([
                'status' => 'waiting_pickup',
                'stored_at' => now()
            ]);

            $locker->update([
                'status' => 'finished'
            ]);

            // ============ SCHEDULE AUTO CLOSE ============
            dispatch(new \App\Jobs\AutoCloseLockerJob($locker->id))->delay(now()->addSeconds(15));
            // =============================================

            // Kirim WhatsApp dengan QR Code
            $this->sendReturnWhatsAppWithQR($this->returnTransaction);

            $this->dispatch('open-locker', ['code' => $locker->code]);

            $this->returnStep = 3;
            $this->dispatch('notify', message: 'Locker opened successfully! Uniform has been returned and marked as Finished.', type: 'success');
        });

        $this->returnIsLoading = false;
    }

    // ============ KIRIM WHATSAPP DENGAN ACCESS CODE & QR CODE ============
    protected function sendReturnWhatsAppWithQR($transaction)
    {
        try {
            $whatsapp = app(WhatsAppService::class);
            $employee = $transaction->employee;
            $locker = $transaction->locker;
            
            $phone = $transaction->phone;
            
            if (!$phone) {
                Log::error('No phone number for Return with QR', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            // Generate QR Code sebagai image
            $qrData = $transaction->access_code;
            $qrImagePath = QRCodeHelper::generateAndSave($transaction->access_code, $qrData);
            
            // Buat QR Code URL untuk scan
            $scanUrl = route('qr-scan', ['accessCode' => $transaction->access_code]);
            
            $message = "*ESD Locker System*\n\n";
            $message .= "Halo *{$employee->name}*,\n\n";
            $message .= "✅ *Seragam Anda telah selesai diperiksa dan siap diambil!*\n\n";
            $message .= "📋 *Detail Transaksi:*\n";
            $message .= "• NIK: {$employee->nik}\n";
            $message .= "• Locker: {$locker->code}\n";
            $message .= "• Status: Siap Diambil\n";
            $message .= "• Waktu: " . now()->format('d/m/Y H:i') . "\n\n";
            $message .= "🔑 *Kode Akses Anda:* `{$transaction->access_code}`\n";
            $message .= "⏰ Kode ini berlaku selama *24 jam*.\n\n";
            $message .= "📱 *Scan QR Code di bawah ini untuk akses cepat:*\n\n";
            $message .= "⚠️ *Simpan kode dan QR Code ini dengan baik!*\n";
            $message .= "Gunakan untuk mengambil seragam Anda.\n\n";
            $message .= "Terima kasih telah menggunakan layanan ESD.\n";
            $message .= "_Pesan ini dikirim otomatis oleh sistem._";

            // Kirim dengan gambar QR Code
            if (file_exists($qrImagePath)) {
                $result = $whatsapp->sendWithQRImage($phone, $message, $qrImagePath);
            } else {
                // Jika QR gagal generate, kirim tanpa gambar
                $whatsapp->send($phone, $message);
            }
            
            Log::info('WhatsApp Return with QR sent successfully', [
                'transaction_id' => $transaction->id,
                'phone' => $phone,
                'access_code' => $transaction->access_code
            ]);
            
        } catch (\Exception $e) {
            Log::error('WhatsApp Return with QR send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }
    // ================================================================

    // ============ NG (Reject Locker) ============

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
            $this->ngLockerData->update([
                'status' => 'ng'
            ]);

            $transaction = UniformTransaction::where('locker_id', $this->ngLockerData->id)
                ->where('status', 'on_progress')
                ->latest()
                ->first();

            if ($transaction) {
                $transaction->update([
                    'status' => 'ng',
                    'notes' => $this->ngReason ?? 'Marked as NG by technician'
                ]);

                // Kirim WhatsApp NG
                $this->sendNgWhatsApp($transaction);
            }

            Log::info('Locker marked as NG', [
                'locker_id' => $this->ngLockerData->id,
                'locker_code' => $this->ngLockerData->code,
                'reason' => $this->ngReason,
                'by' => auth()->user()->name ?? 'System'
            ]);

            $this->ngStep = 3;
            $this->dispatch('notify', message: "Locker {$this->ngLockerData->code} marked as NG successfully!", type: 'warning');
        });
    }

    protected function sendNgWhatsApp($transaction)
    {
        try {
            $whatsapp = app(WhatsAppService::class);
            $employee = $transaction->employee;
            
            $phone = $transaction->phone;
            
            if (!$phone) {
                Log::error('No phone number for NG', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            $message = "*ESD Locker System*\n\n";
            $message .= "Halo *{$employee->name}*,\n\n";
            $message .= "❌ *Pemberitahuan Penting!*\n\n";
            $message .= "Seragam Anda dinyatakan *NG (Not Good)* / Tidak Lolos Pengecekan.\n\n";
            
            if ($transaction->notes) {
                $message .= "📝 *Alasan:* {$transaction->notes}\n\n";
            }
            
            $message .= "📋 *Detail:*\n";
            $message .= "• NIK: {$employee->nik}\n";
            $message .= "• Locker: {$transaction->locker->code}\n";
            $message .= "• Status: NG (Rejected)\n";
            $message .= "• Waktu: " . now()->format('d/m/Y H:i') . "\n\n";
            $message .= "📞 Silahkan hubungi tim ESD untuk informasi lebih lanjut.\n\n";
            $message .= "Terima kasih telah menggunakan layanan ESD.\n";
            $message .= "_Pesan ini dikirim otomatis oleh sistem._";

            $whatsapp->send($phone, $message);
            
            Log::info('WhatsApp NG sent successfully', [
                'transaction_id' => $transaction->id,
                'phone' => $phone
            ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp NG send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }

    // ============ SAVE, EDIT, DELETE ============
    
    public function resetForm()
    {
        $this->reset(['locker_id', 'code', 'status', 'employee_id']);
        $this->modalTitle = 'Add New Locker';
        $this->resetValidation();
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
        $this->selectedLocker = Locker::with('employee')->find($id);

        if (!$this->selectedLocker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        $this->transactionPage = 1;
        $this->showDetail = true;
        $this->dispatch('open-modal', 'locker-detail-modal');
    }

    // ============ ACTION FOR TECHNICIAN ============
    
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

        $transaction = UniformTransaction::where('access_code', $this->takeAccessCode)
            ->where('locker_id', $locker->id)
            ->whereIn('status', ['pending', 'waiting_pickup'])
            ->where('expires_at', '>', now())
            ->first();

        if (!$transaction) {
            $this->dispatch('notify', message: 'Invalid access code or transaction expired!', type: 'error');
            return;
        }

        $locker->markAsInProgress();
        
        $transaction->update([
            'status' => 'on_progress'
        ]);

        $this->showTakeModal = false;
        $this->takeLockerId = null;
        $this->takeAccessCode = '';
        $this->dispatch('close-modal', 'take-locker-modal');
        $this->dispatch('notify', message: 'Locker taken successfully! Now in progress.');
    }

    public function rejectLocker($id)
    {
        return $this->openNgModal($id);
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

        $this->ngLockerData = $locker;
        $this->ngReason = '';
        $this->ngStep = 1;
        $this->dispatch('open-modal', 'ng-locker-modal');
    }

    public function confirmNg()
    {
        if (!$this->ngLockerData) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        DB::transaction(function () {
            $this->ngLockerData->update([
                'status' => 'ng'
            ]);

            $transaction = UniformTransaction::where('locker_id', $this->ngLockerData->id)
                ->where('status', 'on_progress')
                ->latest()
                ->first();

            if ($transaction) {
                $transaction->update([
                    'status' => 'ng',
                    'notes' => $this->ngReason ?? 'Marked as NG by technician'
                ]);

                // Kirim WhatsApp
                $this->sendNgWhatsApp($transaction);
            }

            Log::info('Locker marked as NG', [
                'locker_id' => $this->ngLockerData->id,
                'locker_code' => $this->ngLockerData->code,
                'reason' => $this->ngReason,
                'by' => auth()->user()->name ?? 'System'
            ]);

            $this->dispatch('notify', message: "Locker {$this->ngLockerData->code} marked as NG successfully!", type: 'warning');
        });

        $this->ngLockerData = null;
        $this->ngReason = '';
        $this->ngStep = 1;
        $this->dispatch('close-modal', 'ng-locker-modal');
    }

    public function finishLocker($id)
    {
        $locker = Locker::find($id);
        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        if (!in_array($locker->status, ['in_progress', 'ng'])) {
            $this->dispatch('notify', message: 'Locker must be in progress or NG to be finished!', type: 'error');
            return;
        }

        $locker->markAsFinished();
        $this->dispatch('notify', message: 'Locker work completed!');
    }

    public function resetLocker($id)
    {
        $locker = Locker::find($id);
        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        if ($locker->status !== 'finished') {
            $this->dispatch('notify', message: 'Only Finished lockers can be reset to available!', type: 'error');
            return;
        }

        $locker->markAsAvailable();
        $this->dispatch('notify', message: 'Locker reset to available!');
    }

    public function printThermal($transactionId)
    {
        $transaction = UniformTransaction::with(['employee', 'locker'])->find($transactionId);
        
        if (!$transaction) {
            abort(404, 'Transaction not found');
        }
        
        return redirect()->route('esd.print-label-thermal', ['transactionId' => $transactionId]);
    }

    // ============ DELETE ============
    
    public function confirmDelete($id)
    {
        $locker = Locker::find($id);

        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

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