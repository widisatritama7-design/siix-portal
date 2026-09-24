<?php

namespace App\Livewire\ESD\Garment;

use App\Mail\ESD\UniformNotificationMail;
use App\Models\ESD\Garment\UniformRecipient;
use App\Models\HR\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UniformRecipientManagement extends Component
{
    use WithPagination, WithFileUploads;

    // ===== Filter properties =====
    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;

    // ===== Selection =====
    public $selectedRecipients = [];
    public $selectAll = false;

    // ===== Form modal (create/edit) =====
    public $showFormModal = false;
    public $formMode = 'create';
    public $recipientId = null;

    public $employee_id = null;
    public $nik = '';
    public $name = '';
    public $email = '';
    public $department = '';
    public $date_measure = '';
    public $notes = '';
    public $is_active = true;

    // ===== Duplicate check =====
    public $nikDuplicate = false;
    public $nameDuplicate = false;

    // ===== Employee search =====
    public $employeeSearch = '';
    public $showEmployeeDropdown = false;
    public $employeeResults = [];

    // ===== Email modal =====
    public $showEmailModal = false;
    public $emailMethod = '';
    public $emailSubject = '';
    public $emailMessage = '';
    public $sending = false;
    public $sendResult = null;

    // ===== Attachments =====
    public $attachments = [];

    // ===== Delete modal =====
    public $showDeleteModal = false;
    public $deleteId = null;

    // ===== Inline edit email =====
    public $editingEmailId = null;
    public $editingEmailValue = '';

    // ===== Import =====
    public $showImportModal = false;
    public $importFile = null;
    public $importResult = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    // ===== Select all =====
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRecipients = $this->getFilteredRecipients()
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedRecipients = [];
        }
    }

    public function updatedSelectedRecipients()
    {
        $this->selectAll = false;
    }

    public function clearSelection()
    {
        $this->selectedRecipients = [];
        $this->selectAll = false;
    }

    // ===== Base query =====
    protected function getFilteredRecipients()
    {
        return UniformRecipient::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('department', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($q) {
                $q->where('is_active', $this->statusFilter === 'active');
            })
            ->orderBy('name', 'asc');
    }

    // ===== Mask email helper =====
    public function maskEmail($email)
    {
        if (empty($email) || !str_contains($email, '@')) {
            return '-';
        }

        [, $domain] = explode('@', $email, 2);

        return str_repeat('*', 11) . '@' . $domain;
    }

    // ===== Employee search =====
    public function updatedEmployeeSearch($value)
    {
        if (strlen($value) < 2) {
            $this->employeeResults = [];
            $this->showEmployeeDropdown = false;
            return;
        }

        $registeredEmployeeIds = UniformRecipient::whereNotNull('employee_id')
            ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
            ->pluck('employee_id')
            ->toArray();

        $this->employeeResults = Employee::whereIn('status', [1, 2, 3])
            ->where(function ($q) use ($value) {
                $q->where('nik', 'like', '%' . $value . '%')
                  ->orWhere('name', 'like', '%' . $value . '%')
                  ->orWhere('department', 'like', '%' . $value . '%');
            })
            ->orderBy('name')
            ->limit(15)
            ->get(['id', 'nik', 'name', 'department'])
            ->map(function ($emp) use ($registeredEmployeeIds) {
                $arr = $emp->toArray();
                $arr['is_registered'] = in_array($emp->id, $registeredEmployeeIds);
                return $arr;
            })
            ->toArray();

        $this->showEmployeeDropdown = true;
    }

    public function selectEmployee($id)
    {
        $emp = Employee::find($id);
        if (!$emp) return;

        $exists = UniformRecipient::where('employee_id', $id)
            ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
            ->exists();

        if ($exists) {
            $this->dispatch('notify', message: 'Employee ini sudah terdaftar sebagai recipient!', type: 'error');
            return;
        }

        $this->employee_id = $emp->id;
        $this->nik = $emp->nik;
        $this->name = $emp->name;
        $this->department = $emp->department;

        $this->nikDuplicate = false;
        $this->nameDuplicate = false;

        $this->employeeSearch = $emp->nik . ' - ' . $emp->name;
        $this->showEmployeeDropdown = false;
        $this->employeeResults = [];

        if (!empty($this->nik)) {
            $this->nikDuplicate = UniformRecipient::where('nik', $this->nik)
                ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
                ->exists();
        }

        if (!empty($this->name)) {
            $this->nameDuplicate = UniformRecipient::whereRaw('LOWER(name) = ?', [strtolower(trim($this->name))])
                ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
                ->exists();
        }
    }

    public function clearEmployeeSelection()
    {
        $this->employee_id = null;
        $this->employeeSearch = '';
        $this->employeeResults = [];
        $this->showEmployeeDropdown = false;

        $this->nik = '';
        $this->name = '';
        $this->department = '';

        $this->nikDuplicate = false;
        $this->nameDuplicate = false;
    }

    // ===== Duplicate check =====
    public function updatedNik($value)
    {
        if (empty($value)) {
            $this->nikDuplicate = false;
            return;
        }

        $this->nikDuplicate = UniformRecipient::where('nik', $value)
            ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
            ->exists();
    }

    public function updatedName($value)
    {
        if (empty($value)) {
            $this->nameDuplicate = false;
            return;
        }

        $this->nameDuplicate = UniformRecipient::whereRaw('LOWER(name) = ?', [strtolower(trim($value))])
            ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
            ->exists();
    }

    // ===== Form =====
    public function openCreateModal()
    {
        $this->resetForm();
        $this->formMode = 'create';
        $this->showFormModal = true;
    }

    public function openEditModal($id)
    {
        $recipient = UniformRecipient::findOrFail($id);

        $this->recipientId = $recipient->id;
        $this->employee_id = $recipient->employee_id;
        $this->nik = $recipient->nik;
        $this->name = $recipient->name;
        $this->department = $recipient->department;
        $this->date_measure = $recipient->date_measure
            ? Carbon::parse($recipient->date_measure)->format('Y-m-d')
            : '';
        $this->notes = $recipient->notes;
        $this->is_active = $recipient->is_active;

        if ($recipient->employee_id) {
            $emp = Employee::find($recipient->employee_id);
            $this->employeeSearch = $emp ? ($emp->nik . ' - ' . $emp->name) : '';
        } else {
            $this->employeeSearch = '';
        }

        $this->employeeResults = [];
        $this->showEmployeeDropdown = false;
        $this->nikDuplicate = false;
        $this->nameDuplicate = false;

        $this->formMode = 'edit';
        $this->showFormModal = true;
    }

    public function resetForm()
    {
        $this->recipientId = null;
        $this->employee_id = null;
        $this->nik = '';
        $this->name = '';
        $this->email = '';
        $this->department = '';
        $this->date_measure = '';
        $this->notes = '';
        $this->is_active = true;

        $this->employeeSearch = '';
        $this->employeeResults = [];
        $this->showEmployeeDropdown = false;

        $this->nikDuplicate = false;
        $this->nameDuplicate = false;

        $this->resetErrorBag();
    }

    public function closeFormModal()
    {
        $this->showFormModal = false;
        $this->resetForm();
    }

    public function saveRecipient()
    {
        if (!auth()->user()->can('view employee')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $this->validate([
            'name'         => 'required|string|max:255',
            'nik'          => 'nullable|string|max:50',
            'department'   => 'nullable|string|max:255',
            'date_measure' => 'nullable|date',
            'notes'        => 'nullable|string',
            'is_active'    => 'boolean',
        ]);

        // Cek duplikat NIK
        if (!empty($this->nik)) {
            $existsNik = UniformRecipient::where('nik', $this->nik)
                ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
                ->exists();

            if ($existsNik) {
                $this->addError('nik', 'NIK ini sudah terdaftar di recipient lain.');
                $this->dispatch('notify', message: 'NIK sudah terdaftar!', type: 'error');
                return;
            }
        }

        // Cek duplikat Name
        $existsName = UniformRecipient::whereRaw('LOWER(name) = ?', [strtolower(trim($this->name))])
            ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
            ->exists();

        if ($existsName) {
            $this->addError('name', 'Nama ini sudah terdaftar di recipient lain.');
            $this->dispatch('notify', message: 'Nama sudah terdaftar!', type: 'error');
            return;
        }

        // Cek duplikat Employee
        if ($this->employee_id) {
            $existsEmployee = UniformRecipient::where('employee_id', $this->employee_id)
                ->when($this->recipientId, fn($q) => $q->where('id', '!=', $this->recipientId))
                ->exists();

            if ($existsEmployee) {
                $this->addError('employeeSearch', 'Employee ini sudah terdaftar sebagai recipient.');
                $this->dispatch('notify', message: 'Employee sudah terdaftar!', type: 'error');
                return;
            }
        }

        $data = [
            'employee_id'  => $this->employee_id ?: null,
            'nik'          => $this->nik,
            'name'         => $this->name,
            'department'   => $this->department,
            'date_measure' => $this->date_measure ?: null,
            'notes'        => $this->notes,
            'is_active'    => $this->is_active,
        ];

        if ($this->formMode === 'edit' && $this->recipientId) {
            UniformRecipient::findOrFail($this->recipientId)->update($data);
            $this->dispatch('notify', message: 'Recipient berhasil diupdate.', type: 'success');
        } else {
            UniformRecipient::create($data);
            $this->dispatch('notify', message: 'Recipient berhasil ditambahkan. Silakan isi email via inline edit.', type: 'success');
        }

        $this->closeFormModal();
    }

    // ===== Delete =====
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteRecipient()
    {
        if (!auth()->user()->can('view employee')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if ($this->deleteId) {
            UniformRecipient::findOrFail($this->deleteId)->delete();
            $this->dispatch('notify', message: 'Recipient berhasil dihapus.', type: 'success');
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function toggleActive($id)
    {
        $recipient = UniformRecipient::findOrFail($id);
        $recipient->is_active = !$recipient->is_active;
        $recipient->save();

        $this->dispatch('notify', message: 'Status recipient diupdate.', type: 'success');
    }

    // ===== Inline Edit Email =====
    public function startEditEmail($id)
    {
        if (!auth()->user()->can('edit uniform recipient')) {
            $this->dispatch('notify', message: 'You do not have permission to edit email!', type: 'error');
            return;
        }

        $recipient = UniformRecipient::findOrFail($id);
        $this->editingEmailId = $id;
        $this->editingEmailValue = $recipient->email;
        $this->resetErrorBag();
    }

    public function saveEditEmail()
    {
        if (!auth()->user()->can('edit uniform recipient')) {
            $this->dispatch('notify', message: 'You do not have permission to edit email!', type: 'error');
            return;
        }

        $this->validate([
            'editingEmailValue' => 'required|email|max:255',
        ], [
            'editingEmailValue.required' => 'Email wajib diisi.',
            'editingEmailValue.email' => 'Format email tidak valid.',
        ]);

        $recipient = UniformRecipient::findOrFail($this->editingEmailId);

        $exists = UniformRecipient::where('email', $this->editingEmailValue)
            ->where('id', '!=', $recipient->id)
            ->exists();

        if ($exists) {
            $this->addError('editingEmailValue', 'Email ini sudah dipakai recipient lain.');
            return;
        }

        $recipient->update(['email' => $this->editingEmailValue]);

        $this->editingEmailId = null;
        $this->editingEmailValue = '';
        $this->resetErrorBag();
        $this->dispatch('notify', message: 'Email berhasil diupdate.', type: 'success');
    }

    public function cancelEditEmail()
    {
        $this->editingEmailId = null;
        $this->editingEmailValue = '';
        $this->resetErrorBag();
    }

    // ===== Email =====
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
        $this->attachments = [];

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
                . "Terkait dengan daftar nama yang tercantum di atas, mohon untuk mempersiapkan dan membawa "
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

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function sendEmails()
    {
        if (!auth()->user()->can('view employee')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $this->validate([
            'emailSubject' => 'required|string|max:255',
            'emailMessage' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240',
        ], [
            'attachments.*.max' => 'Ukuran file maksimal 10MB.',
            'attachments.*.file' => 'File tidak valid.',
        ]);

        $this->sending = true;
        $this->sendResult = null;

        $recipients = UniformRecipient::whereIn('id', $this->selectedRecipients)
            ->where('is_active', true)
            ->get();

        $success = 0;
        $failed = 0;
        $errors = [];

        // Cache attachment path
        $attachmentPaths = [];
        foreach ($this->attachments as $file) {
            $attachmentPaths[] = [
                'path' => $file->getRealPath(),
                'name' => $file->getClientOriginalName(),
            ];
        }

        foreach ($recipients as $recipient) {
            if (empty($recipient->email) || !filter_var($recipient->email, FILTER_VALIDATE_EMAIL)) {
                $failed++;
                $errors[] = "{$recipient->name} — email tidak valid ({$recipient->email})";
                continue;
            }

            try {
                $mailable = new UniformNotificationMail(
                    $recipient,
                    $this->emailSubject,
                    $this->emailMessage,
                    $this->emailMethod
                );

                foreach ($attachmentPaths as $att) {
                    if (file_exists($att['path'])) {
                        $mailable->attach($att['path'], ['as' => $att['name']]);
                    }
                }

                Mail::to($recipient->email, $recipient->name)->send($mailable);

                $success++;
            } catch (\Throwable $e) {
                $failed++;
                $errors[] = "{$recipient->name} ({$recipient->email}) — {$e->getMessage()}";
                Log::error("Failed sending to {$recipient->email}: " . $e->getMessage());
            }
        }

        $this->sending = false;
        $this->sendResult = [
            'success' => $success,
            'failed' => $failed,
            'errors' => $errors,
            'method' => $this->emailMethod,
        ];

        $this->dispatch(
            'notify',
            message: "Email terkirim: {$success} sukses, {$failed} gagal.",
            type: $success > 0 ? 'success' : 'warning'
        );

        $this->selectedRecipients = [];
        $this->selectAll = false;
        $this->attachments = [];
    }

    public function closeEmailModal()
    {
        $this->showEmailModal = false;
        $this->emailMethod = '';
        $this->sendResult = null;
        $this->attachments = [];
    }

    // ===== Export CSV =====
    public function exportCsv()
    {
        if (!auth()->user()->can('edit uniform recipient')) {
            $this->dispatch('notify', message: 'You do not have permission to export!', type: 'error');
            return;
        }

        $recipients = UniformRecipient::orderBy('name')->get();

        $filename = 'uniform-recipients-' . date('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($recipients) {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($handle, ['NIK', 'NAME', 'DEPT', 'EMAIL', 'DATE MEASURE']);

            // Rows
            foreach ($recipients as $r) {
                fputcsv($handle, [
                    $r->nik ?? '',
                    $r->name ?? '',
                    $r->department ?? '',
                    $r->email ?? '',
                    $r->date_measure ? Carbon::parse($r->date_measure)->format('Y-m-d') : '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ===== Download Template CSV =====
    public function downloadTemplate()
    {
        if (!auth()->user()->can('edit uniform recipient')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $filename = 'template-import-recipients.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($handle, ['NIK', 'NAME', 'DEPT', 'EMAIL', 'DATE MEASURE']);

            // Contoh
            fputcsv($handle, ['22095652', 'Widi Fajar Satritama', 'MAINTENANCE', 'widi@example.com', date('Y-m-d')]);
            fputcsv($handle, ['22095653', 'Budi Santoso', 'IT', 'budi@example.com', date('Y-m-d', strtotime('+1 week'))]);

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    // ===== Import =====
    public function openImportModal()
    {
        if (!auth()->user()->can('edit uniform recipient')) {
            $this->dispatch('notify', message: 'You do not have permission to import!', type: 'error');
            return;
        }

        $this->importFile = null;
        $this->importResult = null;
        $this->showImportModal = true;
    }

    public function importCsv()
    {
        if (!auth()->user()->can('edit uniform recipient')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt|max:5120',
        ], [
            'importFile.required' => 'File wajib dipilih.',
            'importFile.mimes' => 'Format harus .csv atau .txt.',
            'importFile.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $imported = 0;
        $updated = 0;
        $skipped = 0;
        $errors = [];
        $delimiterDetected = ',';

        try {
            $path = $this->importFile->getRealPath();
            $handle = fopen($path, 'r');

            if (!$handle) {
                throw new \Exception('Gagal membuka file.');
            }

            // Auto-detect delimiter
            $firstLine = fgets($handle);
            rewind($handle);

            $counts = [
                ',' => substr_count($firstLine, ','),
                "\t" => substr_count($firstLine, "\t"),
                ';' => substr_count($firstLine, ';'),
            ];
            arsort($counts);
            $delimiterDetected = array_key_first($counts);

            if ($counts[$delimiterDetected] === 0) {
                $delimiterDetected = ',';
            }

            $rowNumber = 0;
            $header = null;

            while (($row = fgetcsv($handle, 0, $delimiterDetected)) !== false) {
                $rowNumber++;

                // Skip baris kosong
                if (empty(array_filter($row, fn($v) => trim((string) $v) !== ''))) {
                    continue;
                }

                // Header
                if ($rowNumber === 1) {
                    if (isset($row[0])) {
                        $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
                    }

                    $header = array_map(fn($h) => strtolower(trim((string) $h)), $row);
                    continue;
                }

                // Map data
                $data = [];
                foreach ($header as $i => $col) {
                    $data[$col] = isset($row[$i]) ? trim((string) $row[$i]) : '';
                }

                $nik         = $data['nik'] ?? '';
                $name        = $data['name'] ?? '';
                $dept        = $data['dept'] ?? '';
                $email       = $data['email'] ?? '';
                $dateMeasure = $data['date_measure'] ?? '';

                // Validasi name
                if (empty($name)) {
                    $skipped++;
                    $errors[] = "Baris {$rowNumber}: Nama kosong (NIK: '{$nik}').";
                    continue;
                }

                // Validasi email
                if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $skipped++;
                    $errors[] = "Baris {$rowNumber}: Email '{$email}' tidak valid.";
                    continue;
                }

                // Validasi date_measure
                $dateMeasureValue = null;
                if (!empty($dateMeasure)) {
                    try {
                        $dateMeasureValue = Carbon::parse($dateMeasure)->format('Y-m-d');
                    } catch (\Throwable $e) {
                        $skipped++;
                        $errors[] = "Baris {$rowNumber}: Tanggal '{$dateMeasure}' tidak valid.";
                        continue;
                    }
                }

                // Cari employee_id
                $employeeId = null;
                if ($nik) {
                    $emp = Employee::where('nik', $nik)->first();
                    $employeeId = $emp?->id;
                }

                // Cari existing
                $existing = null;
                if ($nik) {
                    $existing = UniformRecipient::where('nik', $nik)->first();
                }
                if (!$existing && $email) {
                    $existing = UniformRecipient::where('email', $email)->first();
                }

                if ($existing) {
                    $existing->update([
                        'employee_id'  => $employeeId ?? $existing->employee_id,
                        'nik'          => $nik ?: $existing->nik,
                        'name'         => $name,
                        'department'   => $dept ?: $existing->department,
                        'email'        => $email ?: $existing->email,
                        'date_measure' => $dateMeasureValue ?? $existing->date_measure,
                    ]);
                    $updated++;
                } else {
                    UniformRecipient::create([
                        'employee_id'  => $employeeId,
                        'nik'          => $nik,
                        'name'         => $name,
                        'department'   => $dept,
                        'email'        => $email,
                        'date_measure' => $dateMeasureValue,
                        'is_active'    => true,
                    ]);
                    $imported++;
                }
            }

            fclose($handle);

            $this->importResult = [
                'imported'  => $imported,
                'updated'   => $updated,
                'skipped'   => $skipped,
                'errors'    => $errors,
                'delimiter' => $delimiterDetected === "\t" ? 'TAB' : $delimiterDetected,
            ];

            $this->dispatch(
                'notify',
                message: "Import selesai: {$imported} baru, {$updated} diupdate, {$skipped} dilewati.",
                type: 'success'
            );

            $this->importFile = null;
        } catch (\Throwable $e) {
            $this->dispatch('notify', message: 'Import gagal: ' . $e->getMessage(), type: 'error');
            Log::error('Import failed: ' . $e->getMessage());
        }
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->importFile = null;
        $this->importResult = null;
    }

    // ===== Render =====
    public function render()
    {
        if (!auth()->user()->can('view employee')) {
            abort(403, 'Unauthorized access.');
        }

        $recipients = $this->getFilteredRecipients()->paginate($this->perPage);

        return view('livewire.esd.garment.uniform-recipient-management', [
            'recipients'         => $recipients,
            'totalRecipients'    => UniformRecipient::count(),
            'activeRecipients'   => UniformRecipient::where('is_active', true)->count(),
            'inactiveRecipients' => UniformRecipient::where('is_active', false)->count(),
        ]);
    }
}