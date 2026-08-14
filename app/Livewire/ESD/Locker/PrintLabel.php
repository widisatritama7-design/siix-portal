<?php

namespace App\Livewire\ESD\Locker;

use Livewire\Component;
use App\Models\ESD\Locker\UniformTransaction;

class PrintLabel extends Component
{
    public $transaction;
    public $accessCode;
    public $employeeName;
    public $employeeNik;
    public $department;
    public $lockerCode;

    public function mount($transactionId)
    {
        $this->transaction = UniformTransaction::with(['employee', 'locker'])
            ->find($transactionId);

        if (!$this->transaction) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $this->accessCode = $this->transaction->access_code;
        $this->employeeName = $this->transaction->employee->name;
        $this->employeeNik = $this->transaction->employee->nik;
        $this->department = $this->transaction->employee->department;
        $this->lockerCode = $this->transaction->locker->code;
    }

    public function render()
    {
        return view('livewire.esd.locker.print-label');
    }
}