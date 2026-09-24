<?php

namespace App\Livewire\ESD\Garment;

use App\Mail\ESD\UniformNotificationMail;
use App\Models\HR\Employee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeUniformNotification extends Component
{
    use WithPagination;

    // ===== Filter properties =====
    public $search = '';
    public $departmentFilter = '';
    public $statusFilter = '';
    public $uniformStatusFilter = '';
    public $perPage = 10;

    // ===== Selection =====
    public $selectedEmployees = [];
    public $selectAll = false;

    // ===== Email modal =====
    public $showEmailModal = false;
    public $emailMethod = ''; // 'info_esd' | 'reminder'
    public $emailSubject = '';
    public $emailMessage = '';
    public $sending = false;
    public $sendResult = null;

    // ===== Detail modal =====
    public $showDetailModal = false;
    public $detailEmployee = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'departmentFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'uniformStatusFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    // ===== Reset page saat filter berubah =====
    public function updatingSearch() { $this->resetPage(); }
    public function updatingDepartmentFilter() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingUniformStatusFilter() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    // ===== Select all =====
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedEmployees = $this->getFilteredEmployees()
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedEmployees = [];
        }
    }

    public function updatedSelectedEmployees()
    {
        $this->selectAll = false;
    }

    public function clearSelection()
    {
        $this->selectedEmployees = [];
        $this->selectAll = false;
    }

    // ===== Departments untuk filter =====
    public function getDepartmentsProperty()
    {
        return Employee::whereIn('status', [1, 2, 3])
            ->select('department')
            ->distinct()
            ->whereNotNull('department')
            ->pluck('department');
    }

    // ===== Base query =====
    protected function getFilteredEmployees()
    {
        return Employee::query()
            ->with(['esdUniformTransactions' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }])
            ->whereIn('status', [1, 2, 3])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('department', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->departmentFilter, fn($q) => $q->where('department', $this->departmentFilter))
            ->when($this->uniformStatusFilter, function ($q) {
                if ($this->uniformStatusFilter === 'has_active') {
                    $q->whereHas('esdUniformTransactions', function ($sub) {
                        $sub->whereIn('status', ['pending', 'on_progress', 'waiting_pickup']);
                    });
                } elseif ($this->uniformStatusFilter === 'no_active') {
                    $q->whereDoesntHave('esdUniformTransactions', function ($sub) {
                        $sub->whereIn('status', ['pending', 'on_progress', 'waiting_pickup']);
                    });
                } elseif ($this->uniformStatusFilter === 'has_email') {
                    $q->whereNotNull('email')->where('email', '!=', '');
                } elseif ($this->uniformStatusFilter === 'no_email') {
                    $q->where(function ($sub) {
                        $sub->whereNull('email')->orWhere('email', '');
                    });
                }
            })
            ->orderBy('department', 'asc')
            ->orderBy('nik', 'asc');
    }

    public function openEmailModal($method)
    {
        if (!auth()->user()->can('view employee')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->selectedRecipients)) {
            $this->dispatch('notify', message: 'Pilih minimal 1 recipient terlebih dahulu.', type: 'warning');
            return;
        }

        $this->emailMethod = $method;
        $this->sendResult = null;

        if ($method === 'info_esd') {
            $this->emailSubject = 'ESD Garment Measurement';

            $this->emailMessage = "Selamat Pagi,\n"
                . "Melanjutkan program yang telah dilaksanakan pada tahun sebelumnya terkait ESD (Electro Static Discharge), "
                . "kami akan melakukan pengukuran uniform/seragam kepada masing-masing karyawan/i untuk mengecek "
                . "kesesuaian standar berdasarkan ANSI/ESD S20.20-2021.\n\n"
                . "Adapun detail pelaksanaan pengukuran uniform adalah sebagai berikut :\n"
                . "Teknis Pengumpulan dan Pengambilan Seragam (Petunjuk terlampir)\n\n"
                . "Waktu pengumpulan seragam : (Kunci loker Wajib di ambil untuk keamanan seragam)\n"
                . "07:00 - 09:00 (Shift 1 dan Non-Shift)\n"
                . "14:30 - 16:00 (Shift 2)\n"
                . "22:30 - 00:00 (Shift 3)\n\n"
                . "Waktu pengambilan seragam : (Kunci loker Wajib dikembalikan)\n"
                . "14:30 (Shift 1 dan Non-Shift) di hari yang sama\n"
                . "17:00 (Shift 2 dan 3) Hari berikutnya\n\n"
                . "Mohon untuk mempersiapkan dan membawa "
                . "seragam lengkap (1 set), yaitu: Celana, Baju, Hijab, untuk dilakukan pengecekan oleh tim ESD.\n\n"
                . "Attention:\n"
                . "Toleransi pembawaan seragam hanya sampai hari Jumat. Apabila melewati batas tersebut, "
                . "maka akan dilakukan pengecekan secara langsung (on the spot), di mana karyawan wajib "
                . "melakukan pergantian menggunakan smoke, dan seragam akan dicek langsung oleh tim ESD.\n\n";

        } else {
            $this->emailSubject = 'Reminder: ESD Garment Measurement';

            $this->emailMessage = "Selamat Pagi,\n"
                . "Ini adalah pengingat terkait program pengukuran uniform/seragam ESD (Electro Static Discharge) "
                . "yang sedang berjalan. Kami mengingatkan kembali bahwa Anda diharapkan SEGERA membawa "
                . "seragam kerja Anda untuk dilakukan pengecekan kesesuaian standar berdasarkan ANSI/ESD S20.20-2021.\n\n"
                . "Adapun detail pelaksanaan pengukuran uniform adalah sebagai berikut :\n"
                . "Waktu pengumpulan seragam : (Kunci loker Wajib di ambil untuk keamanan seragam)\n"
                . "07:00 - 09:00 (Shift 1 dan Non-Shift)\n"
                . "14:30 - 16:00 (Shift 2)\n"
                . "22:30 - 00:00 (Shift 3)\n\n"
                . "Waktu pengambilan seragam : (Kunci loker Wajib dikembalikan)\n"
                . "14:30 (Shift 1 dan Non-Shift) di hari yang sama\n"
                . "17:00 (Shift 2 dan 3) Hari berikutnya\n\n"
                . "Mohon untuk mempersiapkan dan membawa seragam lengkap (1 set), yaitu: "
                . "Celana, Baju, Hijab, untuk dilakukan pengecekan oleh tim ESD.\n\n"
                . "Attention:\n"
                . "Toleransi pembawaan seragam hanya sampai hari Jumat. Apabila melewati batas tersebut, "
                . "maka akan dilakukan pengecekan secara langsung (on the spot), di mana karyawan wajib "
                . "melakukan pergantian menggunakan smoke, dan seragam akan dicek langsung oleh tim ESD.\n\n";
        }

        $this->showEmailModal = true;
    }

    // ===== Kirim email =====
    public function sendEmails()
    {
        if (!auth()->user()->can('view employee')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $this->validate([
            'emailSubject' => 'required|string|max:255',
            'emailMessage' => 'required|string',
        ]);

        $this->sending = true;
        $this->sendResult = null;

        $employees = Employee::whereIn('id', $this->selectedEmployees)->get();

        $success = 0;
        $failed = 0;
        $noEmail = 0;
        $errors = [];

        foreach ($employees as $employee) {
            if (empty($employee->email) || !filter_var($employee->email, FILTER_VALIDATE_EMAIL)) {
                $noEmail++;
                $errors[] = "{$employee->name} ({$employee->nik}) — email tidak valid/kosong";
                continue;
            }

            try {
                Mail::to($employee->email, $employee->name)
                    ->send(new UniformNotificationMail(
                        $employee,
                        $this->emailSubject,
                        $this->emailMessage,
                        $this->emailMethod
                    ));

                $success++;
            } catch (\Throwable $e) {
                $failed++;
                $errors[] = "{$employee->name} ({$employee->nik}) — {$e->getMessage()}";
                Log::error("Failed sending uniform notification to {$employee->email}: " . $e->getMessage());
            }
        }

        $this->sending = false;
        $this->sendResult = [
            'success' => $success,
            'failed' => $failed,
            'no_email' => $noEmail,
            'errors' => $errors,
            'method' => $this->emailMethod,
        ];

        $this->dispatch(
            'notify',
            message: "Email terkirim: {$success} sukses, {$failed} gagal, {$noEmail} tanpa email.",
            type: $success > 0 ? 'success' : 'warning'
        );

        $this->selectedEmployees = [];
        $this->selectAll = false;
    }

    public function closeEmailModal()
    {
        $this->showEmailModal = false;
        $this->emailMethod = '';
        $this->sendResult = null;
    }

    // ===== Detail =====
    public function viewDetail($id)
    {
        $this->detailEmployee = Employee::with(['esdUniformTransactions' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        $this->showDetailModal = true;
    }

    // ===== Helper =====
    public function getStatusLabel($status)
    {
        return match ($status) {
            1 => 'Permanent',
            2 => 'Contract',
            3 => 'Magang',
            default => 'Unknown',
        };
    }

    public function getStatusColor($status)
    {
        return match ($status) {
            1 => 'blue',
            2 => 'yellow',
            3 => 'purple',
            default => 'gray',
        };
    }

    // ===== Render =====
    public function render()
    {
        if (!auth()->user()->can('view employee')) {
            abort(403, 'Unauthorized access.');
        }

        $employees = $this->getFilteredEmployees()->paginate($this->perPage);

        return view('livewire.esd.garment.employee-uniform-notification', [
            'employees' => $employees,
            'totalEmployees' => Employee::whereIn('status', [1, 2, 3])->count(),
            'withEmailCount' => Employee::whereIn('status', [1, 2, 3])
                ->whereNotNull('email')->where('email', '!=', '')->count(),
            'withActiveUniformCount' => Employee::whereIn('status', [1, 2, 3])
                ->whereHas('esdUniformTransactions', function ($q) {
                    $q->whereIn('status', ['pending', 'on_progress', 'waiting_pickup']);
                })->count(),
            'statusOptions' => [1 => 'Permanent', 2 => 'Contract', 3 => 'Magang'],
        ]);
    }
}