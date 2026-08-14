<?php

namespace App\Livewire\ESD\Locker;

use Livewire\Component;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use App\Models\ESD\Locker\Locker;
use Illuminate\Support\Facades\DB;

class LockerInfo extends Component
{
    // Untuk Cek Status
    public $nik;
    public $employee = null;
    public $transactions = [];

    // Untuk Store
    public $store_nik;
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
            'store_nik' => 'required|string|max:20|exists:tb_hr_employee,nik'
        ], [
            'store_nik.required' => 'NIK is required',
            'store_nik.exists' => 'NIK not found in database'
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

        DB::transaction(function () {
            // Cari locker dengan status 'available' (tersedia)
            $locker = Locker::available()->inRandomOrder()->first();

            if (!$locker) {
                $this->dispatch('notify', message: 'Sorry, all lockers are full!', type: 'error');
                $this->isLoading = false;
                return;
            }

            $transaction = UniformTransaction::create([
                'employee_id' => $this->store_employee->id,
                'locker_id' => $locker->id,
                'type' => 'store',
                'status' => 'pending'
            ]);

            $transaction->generateAccessCode();

            // Update locker status menjadi 'open' (sedang digunakan)
            $locker->update([
                'status' => 'open',
                'employee_id' => $this->store_employee->id,
                'locked_until' => now()->addSeconds(15)
            ]);

            $this->access_code = $transaction->access_code;
            $this->locker_code = $locker->code;
            $this->store_step = 3;

            $this->sendWhatsAppNotification($transaction);
            $this->dispatch('open-locker', ['code' => $locker->code]);
            $this->dispatch('notify', message: 'Locker opened successfully! Please store your uniform.', type: 'success');
        });

        $this->isLoading = false;
    }

    public function resetStore()
    {
        $this->reset(['store_nik', 'store_employee', 'store_step', 'locker_code', 'access_code']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->modalStore = false;
    }

    // ============ TAKE ============
    public function checkTakeCode()
    {
        $this->validate([
            'take_access_code' => 'required|string|max:50'
        ], [
            'take_access_code.required' => 'Access code is required'
        ]);

        $this->take_transaction = UniformTransaction::where('access_code', $this->take_access_code)
            ->whereIn('status', ['pending', 'waiting_pickup'])
            ->where('expires_at', '>', now())
            ->with(['employee', 'locker'])
            ->first();

        if (!$this->take_transaction) {
            $this->dispatch('notify', message: 'Invalid access code or expired!', type: 'error');
            return;
        }

        if ($this->take_transaction->locker->isLocked()) {
            $this->dispatch('notify', message: 'Locker is locked, please wait a moment!', type: 'error');
            return;
        }

        $this->take_step = 2;
    }

    public function openTakeLocker()
    {
        $this->isLoading = true;

        DB::transaction(function () {
            $locker = $this->take_transaction->locker;

            $locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            $this->take_transaction->update([
                'status' => 'completed',
                'taken_at' => now()
            ]);

            // Update locker status menjadi 'available' (tersedia kembali)
            $locker->update([
                'status' => 'available',
                'employee_id' => null
            ]);

            $this->dispatch('open-locker', ['code' => $locker->code]);
            $this->take_step = 3;
            $this->dispatch('notify', message: 'Locker opened successfully! Please take your uniform.', type: 'success');
        });

        $this->isLoading = false;
    }

    public function resetTake()
    {
        $this->reset(['take_access_code', 'take_transaction', 'take_step']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->modalTake = false;
    }

    // ============ WHATSAPP ============
    protected function sendWhatsAppNotification($transaction)
    {
        $employee = $this->store_employee;
        $message = "Hello {$employee->name},\n\n";
        $message .= "You have stored your uniform in locker {$transaction->locker->code}\n";
        $message .= "Your access code: {$transaction->access_code}\n";
        $message .= "This code is valid for 24 hours.\n\n";
        $message .= "Thank you for using ESD service.";

        try {
            \Log::info('WhatsApp notification sent to: ' . $employee->nik, ['message' => $message]);
        } catch (\Exception $e) {
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
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