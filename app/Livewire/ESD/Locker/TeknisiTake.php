<?php

namespace App\Livewire\ESD\Locker;

use Livewire\Component;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use Illuminate\Support\Facades\DB;

class TeknisiTake extends Component
{
    public $nik;
    public $employee = null;
    public $transaction = null;
    public $step = 1;
    public $isLoading = false;

    protected $rules = [
        'nik' => 'required|string|max:20|exists:tb_hr_employee,nik'
    ];

    protected $messages = [
        'nik.required' => 'NIK wajib diisi',
        'nik.exists' => 'NIK tidak ditemukan di database'
    ];

    public function searchEmployee()
    {
        $this->validate();

        $this->employee = Employee::where('nik', $this->nik)->first();

        if (!$this->employee) {
            $this->dispatch('notify', message: 'Data karyawan tidak ditemukan!', type: 'error');
            return;
        }

        // Cek apakah ada transaksi dengan status pending (belum dicek)
        $this->transaction = UniformTransaction::where('employee_id', $this->employee->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$this->transaction) {
            $this->dispatch('notify', message: 'Tidak ada seragam yang perlu dicek untuk karyawan ini!', type: 'error');
            return;
        }

        $this->step = 2;
    }

    public function printLabel()
    {
        $this->isLoading = true;

        DB::transaction(function () {
            // Update status transaksi menjadi on_progress
            $this->transaction->update([
                'status' => 'on_progress',
                'taken_at' => now()
            ]);

            // Update locker status
            $this->transaction->locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            // Kirim notifikasi WhatsApp ke user
            $this->sendWhatsAppNotification(
                $this->employee,
                "Halo {$this->employee->name}, seragam Anda sedang dalam proses pengecekan (On Progress Measure)"
            );

            $this->dispatch('notify', message: 'Label berhasil dicetak! Status berubah menjadi On Progress.', type: 'success');
        });

        $this->isLoading = false;

        // Redirect ke halaman print
        return redirect()->route('esd.print-label-thermal', ['id' => $this->transaction->id]);
    }

    public function scanAndOpen()
    {
        $this->isLoading = true;

        DB::transaction(function () {
            $locker = $this->transaction->locker;

            $locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            // Dispatch event buka loker
            $this->dispatch('open-locker', ['code' => $locker->code]);

            $this->step = 4;
            $this->dispatch('notify', message: 'Loker berhasil dibuka! Ambil seragam untuk dicek.', type: 'success');
        });

        $this->isLoading = false;
    }

    protected function sendWhatsAppNotification($employee, $message)
    {
        try {
            \Log::info('WhatsApp notification sent to: ' . $employee->nik, ['message' => $message]);
        } catch (\Exception $e) {
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset(['nik', 'employee', 'transaction', 'step']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.esd.locker.teknisi-take');
    }
}