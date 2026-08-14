<?php

namespace App\Livewire\ESD\Locker;

use Livewire\Component;
use App\Models\ESD\Locker\UniformTransaction;
use Illuminate\Support\Facades\DB;

class TeknisiReturn extends Component
{
    public $access_code;
    public $transaction = null;
    public $step = 1;
    public $isLoading = false;

    protected $rules = [
        'access_code' => 'required|string|max:50'
    ];

    protected $messages = [
        'access_code.required' => 'Kode akses wajib diisi'
    ];

    public function checkCode()
    {
        $this->validate();

        // Cari transaksi dengan status on_progress (sedang dicek)
        $this->transaction = UniformTransaction::where('access_code', $this->access_code)
            ->where('status', 'on_progress')
            ->with(['employee', 'locker'])
            ->first();

        if (!$this->transaction) {
            $this->dispatch('notify', message: 'Kode akses tidak valid atau tidak dalam proses pengecekan!', type: 'error');
            return;
        }

        $this->step = 2;
    }

    public function returnUniform()
    {
        $this->isLoading = true;

        DB::transaction(function () {
            $locker = $this->transaction->locker;

            // Buka loker
            $locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            // Update transaksi menjadi waiting_pickup (menunggu diambil user)
            $this->transaction->update([
                'status' => 'waiting_pickup',
                'stored_at' => now()
            ]);

            // Dispatch event buka loker
            $this->dispatch('open-locker', ['code' => $locker->code]);

            // Kirim notifikasi WhatsApp ke user
            $this->sendWhatsAppNotification(
                $this->transaction->employee,
                "Halo {$this->transaction->employee->name}, seragam telah selesai dicek. Mohon segera diambil."
            );

            $this->step = 3;
            $this->dispatch('notify', message: 'Loker berhasil dibuka! Silakan simpan seragam yang sudah dicek.', type: 'success');
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
        $this->reset(['access_code', 'transaction', 'step']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.esd.locker.teknisi-return');
    }
}