<?php

namespace App\Livewire\ESD\Locker;

use Livewire\Component;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use App\Models\ESD\Locker\Locker;
use Illuminate\Support\Facades\DB;
use App\Services\WhatsAppService;
use App\Helpers\PhoneHelper;
use Illuminate\Support\Facades\Log;

class LockerInfo extends Component
{
    // Untuk Cek Status
    public $nik;
    public $employee = null;
    public $transactions = [];

    // Untuk Store
    public $store_nik;
    public $store_phone;
    public $store_employee = null;
    public $store_step = 1;
    public $locker_code = null;
    public $access_code = null;

    // Untuk Take
    public $take_access_code;
    public $take_transaction = null;
    public $take_step = 1;

    // Untuk Daftar Loker
    public $searchLocker = '';

    public $isLoading = false;

    // Modal kontrol
    public $modalStatus = false;
    public $modalStore = false;
    public $modalTake = false;

    // ============ CEK STATUS ============
    public function checkStatus()
    {
        $this->validate([
            'nik' => 'required|string|max:20|exists:tb_hr_employee,nik'
        ], [
            'nik.required' => 'NIK is required',
            'nik.exists' => 'NIK not found in database'
        ]);

        $this->employee = Employee::where('nik', $this->nik)->first();
        
        if ($this->employee) {
            $this->transactions = UniformTransaction::where('employee_id', $this->employee->id)
                ->with(['locker', 'employee'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function resetStatus()
    {
        $this->reset(['nik', 'employee', 'transactions']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->modalStatus = false;
    }

    // ============ STORE ============
    public function checkStoreNik()
    {
        $this->validate([
            'store_nik' => 'required|string|max:20|exists:tb_hr_employee,nik',
            'store_phone' => 'required|string|max:20|regex:/^[0-9]{10,15}$/'
        ], [
            'store_nik.required' => 'NIK is required',
            'store_nik.exists' => 'NIK not found in database',
            'store_phone.required' => 'WhatsApp number is required',
            'store_phone.regex' => 'WhatsApp number must be 10-15 digits'
        ]);

        $this->store_employee = Employee::where('nik', $this->store_nik)->first();

        if (!$this->store_employee) {
            $this->dispatch('notify', message: 'Employee data not found!', type: 'error');
            return;
        }

        // Cek apakah karyawan sudah ada transaksi aktif
        $activeTransaction = UniformTransaction::where('employee_id', $this->store_employee->id)
            ->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
            ->first();

        if ($activeTransaction) {
            $this->dispatch('notify', message: 'You still have an active transaction!', type: 'error');
            return;
        }

        $this->store_step = 2;
    }

    public function storeUniform()
    {
        $this->isLoading = true;

        try {
            DB::transaction(function () {
                $locker = Locker::available()->inRandomOrder()->first();

                if (!$locker) {
                    throw new \Exception('Sorry, all lockers are full!');
                }

                $formattedPhone = PhoneHelper::formatToInternational($this->store_phone);

                $transaction = UniformTransaction::create([
                    'employee_id' => $this->store_employee->id,
                    'phone' => $formattedPhone,
                    'locker_id' => $locker->id,
                    'type' => 'store',
                    'status' => 'pending'
                ]);

                $transaction->generateAccessCode();

                // Update locker status menjadi 'open' dan buka loker
                $locker->update([
                    'status' => 'open',
                    'employee_id' => $this->store_employee->id,
                    'locked_until' => now()->addSeconds(15),
                    'is_open' => true,
                    'opened_at' => now()
                ]);

                $this->access_code = $transaction->access_code;
                $this->locker_code = $locker->code;
                $this->store_step = 3;

                // Kirim WhatsApp
                $this->sendStoreWhatsApp($transaction);

                // ============ SCHEDULE AUTO CLOSE ============
                dispatch(new \App\Jobs\AutoCloseLockerJob($locker->id))->delay(now()->addSeconds(15));
                // =============================================

                $this->dispatch('open-locker', ['code' => $locker->code]);
                $this->dispatch('notify', message: 'Locker opened successfully! Please store your uniform.', type: 'success');
                $this->dispatch('auto-close-store');
            });
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
            Log::error('Store uniform error: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    // ============ KIRIM WHATSAPP STORE (TANPA QR CODE) ============
    protected function sendStoreWhatsApp($transaction)
    {
        try {
            $whatsapp = app(WhatsAppService::class);
            $employee = $this->store_employee;
            
            $phone = $transaction->phone;
            
            if (!$phone) {
                Log::error('No phone number for WhatsApp Store', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            $message = "*ESD Locker System*\n\n";
            $message .= "Halo *{$employee->name}*,\n\n";
            $message .= "✅ Anda telah menyimpan seragam di locker *{$transaction->locker->code}*\n\n";
            $message .= "📋 *Detail Transaksi:*\n";
            $message .= "• NIK: {$employee->nik}\n";
            $message .= "• Locker: {$transaction->locker->code}\n";
            $message .= "• Status: Menunggu Pengecekan\n\n";
            $message .= "⏳ Seragam Anda akan segera diperiksa oleh tim ESD.\n";
            $message .= "Anda akan mendapat notifikasi setelah selesai.\n\n";
            $message .= "Terima kasih telah menggunakan layanan ESD.\n";
            $message .= "_Pesan ini dikirim otomatis oleh sistem._";

            $whatsapp->send($phone, $message);
            
            Log::info('WhatsApp Store sent successfully', [
                'transaction_id' => $transaction->id,
                'phone' => $phone
            ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp Store send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }

    public function resetStore()
    {
        $this->reset(['store_nik', 'store_phone', 'store_employee', 'store_step', 'locker_code', 'access_code']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->modalStore = false;
    }

    public function checkTakeCode()
    {
        $this->validate([
            'take_access_code' => 'required|string|max:50'
        ], [
            'take_access_code.required' => 'Access code is required'
        ]);

        Log::info('checkTakeCode called', ['code' => $this->take_access_code]);

        // Cari transaksi dengan status waiting_pickup
        $this->take_transaction = UniformTransaction::where('access_code', $this->take_access_code)
            ->where('status', 'waiting_pickup')
            ->with(['employee', 'locker'])
            ->first();

        if (!$this->take_transaction) {
            Log::warning('Transaction not found', ['code' => $this->take_access_code]);
            $this->dispatch('notify', message: 'Invalid access code or uniform not ready!', type: 'error');
            return;
        }

        Log::info('Transaction found', [
            'id' => $this->take_transaction->id,
            'locker_code' => $this->take_transaction->locker->code,
            'locker_status' => $this->take_transaction->locker->status
        ]);

        // LANGSUNG KE STEP 2
        $this->take_step = 2;
    }

    public function openTakeLocker()
    {
        $this->isLoading = true;

        try {
            DB::transaction(function () {
                $locker = $this->take_transaction->locker;

                // BUKA LOKER - status TETAP 'finished'
                $locker->update([
                    'locked_until' => now()->addSeconds(15),
                    'is_open' => true,
                    'opened_at' => now()
                    // STATUS TETAP 'finished', JANGAN UBAH!
                ]);

                // UPDATE TRANSAKSI
                $this->take_transaction->update([
                    'status' => 'completed',
                    'taken_at' => now()
                ]);

                // KOSONGKAN EMPLOYEE_ID
                $locker->update([
                    'employee_id' => null
                ]);

                // KIRIM WHATSAPP
                $this->sendTakeWhatsApp($this->take_transaction);

                // DISPATCH AUTO CLOSE 15 DETIK
                dispatch(new \App\Jobs\AutoCloseLockerJob($locker->id))->delay(now()->addSeconds(15));

                $this->dispatch('open-locker', ['code' => $locker->code]);
                $this->take_step = 3;
                $this->dispatch('notify', message: 'Locker opened successfully! Please take your uniform.', type: 'success');
                $this->dispatch('auto-close-take');
            });
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to open locker: ' . $e->getMessage(), type: 'error');
            Log::error('Take locker error: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    // ============ METHOD SCHEDULE AUTO CLOSE (TANPA QUEUE) ============
    protected function scheduleAutoClose($lockerId)
    {
        // Simpan ke database atau jalankan dengan cron
        // Atau kita bisa menggunakan sleep, tapi TIDAK DISARANKAN di web request
        
        // ALTERNATIF: Simpan ke tabel schedule terpisah
        // \App\Models\AutoCloseSchedule::create([
        //     'locker_id' => $lockerId,
        //     'scheduled_at' => now()->addSeconds(15)
        // ]);
    }

    protected function sendTakeWhatsApp($transaction)
    {
        try {
            $whatsapp = app(WhatsAppService::class);
            $employee = $transaction->employee;
            
            $phone = $transaction->phone;
            
            if (!$phone) {
                Log::error('No phone number for WhatsApp Take', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            $message = "*ESD Locker System*\n\n";
            $message .= "Halo *{$employee->name}*,\n\n";
            $message .= "✅ Anda telah mengambil seragam dari locker *{$transaction->locker->code}*\n\n";
            $message .= "📋 *Detail Transaksi:*\n";
            $message .= "• NIK: {$employee->nik}\n";
            $message .= "• Locker: {$transaction->locker->code}\n";
            $message .= "• Waktu: " . now()->format('d/m/Y H:i') . "\n";
            $message .= "• Status: Selesai Diambil\n\n";
            $message .= "Terima kasih telah menggunakan layanan ESD.\n";
            $message .= "_Pesan ini dikirim otomatis oleh sistem._";

            $whatsapp->send($phone, $message);
            
            Log::info('WhatsApp Take sent successfully', [
                'transaction_id' => $transaction->id,
                'phone' => $phone
            ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp Take send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }

    public function resetTake()
    {
        $this->reset(['take_access_code', 'take_transaction', 'take_step']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->modalTake = false;
    }

    // ============ OPEN MODAL ============
    public function openModal($modal)
    {
        if ($modal === 'status') {
            $this->modalStatus = true;
        } elseif ($modal === 'store') {
            $this->modalStore = true;
        } elseif ($modal === 'take') {
            $this->modalTake = true;
        }
    }

    public function render()
    {
        $lockers = Locker::when($this->searchLocker, function ($query) {
                $query->where('code', 'like', '%' . $this->searchLocker . '%');
            })
            ->orderBy('code')
            ->get();

        return view('livewire.esd.locker.locker-info', [
            'lockers' => $lockers
        ]);
    }
}