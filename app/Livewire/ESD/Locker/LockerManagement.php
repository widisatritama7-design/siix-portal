<?php

namespace App\Livewire\ESD\Locker;

use App\Models\ESD\Locker\Locker;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\ESD\Garment\GarmentDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class LockerManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterDept = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    
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
    
    // ============ PROPERNTI UNTUK GARMENT MEASUREMENT ============
    public $returnGarmentSearch = '';
    public $returnGarmentResults = [];
    public $returnShowGarmentList = false;
    public $returnSelectedGarment = null;
    public $returnSelectedGarmentId = null;

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

    // Untuk aktivitas log
    public $showActivityModal = false;
    public $selectedLockerForActivity = null;
    public $activityPage = 1;
    public $perPageActivities = 10;

    // Status editing
    public $editingId = null;
    public $editingStatus = '';

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

    // ============ RESET FILTERS ============
    public function resetFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterDept = '';
        $this->filterDateFrom = '';
        $this->filterDateUntil = '';
    }

    // ============ STATUS EDITING ============
    public function startEditingStatus($id, $currentStatus)
    {
        $this->editingId = $id;
        $this->editingStatus = $currentStatus;
    }

    public function updateStatus($id)
    {
        $locker = Locker::find($id);
        if ($locker) {
            $locker->update(['status' => $this->editingStatus]);
            $this->dispatch('notify', message: "Status updated to {$this->editingStatus}", type: 'success');
        }
        $this->editingId = null;
        $this->editingStatus = '';
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

            // Kirim Email
            $this->sendTeknisiTakeEmail($this->teknisiTakeTransaction);

            $this->dispatch('notify', message: 'Label printed successfully! Status changed to In Progress.', type: 'success');
        });

        $this->teknisiTakeIsLoading = false;
        $this->teknisiTakeStep = 3;
    }

    protected function sendTeknisiTakeEmail($transaction)
    {
        try {
            $employee = $transaction->employee;
            $email = $transaction->email;
            
            if (!$email) {
                Log::error('No email for Teknisi Take', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            $data = [
                'employee_name' => $employee->name,
                'nik' => $employee->nik,
                'locker_code' => $transaction->locker->code,
                'type' => 'checking',
                'status' => 'Sedang Diperiksa',
                'datetime' => now()->format('d/m/Y H:i')
            ];

            Mail::to($email)->send(new \App\Mail\ESD\LockerNotificationMail($data));
            
            Log::info('Email Teknisi Take (Checking) sent successfully', [
                'transaction_id' => $transaction->id,
                'email' => $email
            ]);
        } catch (\Exception $e) {
            Log::error('Email Teknisi Take send failed: ' . $e->getMessage(), [
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
        $this->reset([
            'returnAccessCode', 
            'returnTransaction', 
            'returnStep',
            'returnGarmentSearch',
            'returnGarmentResults',
            'returnShowGarmentList',
            'returnSelectedGarment',
            'returnSelectedGarmentId'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function searchReturnGarment()
    {
        if (strlen($this->returnGarmentSearch) < 2) {
            $this->returnGarmentResults = [];
            $this->returnShowGarmentList = false;
            return;
        }

        $this->returnGarmentResults = GarmentDetail::join('tb_hr_employee', 'tb_esd_garment_details.nik', '=', 'tb_hr_employee.id')
            ->where('tb_hr_employee.nik', 'like', '%' . $this->returnGarmentSearch . '%')
            ->orWhere('tb_hr_employee.name', 'like', '%' . $this->returnGarmentSearch . '%')
            ->select('tb_esd_garment_details.*', 'tb_hr_employee.nik as employee_nik', 'tb_hr_employee.name as employee_name')
            ->orderBy('tb_esd_garment_details.next_date', 'DESC') // Urutkan dari terbaru
            ->limit(10)
            ->get();

        $this->returnShowGarmentList = true;
    }

    public function selectReturnGarment($id)
    {
        $garment = GarmentDetail::with('garment') // Relasi ke employee
            ->find($id);
        
        if ($garment) {
            $this->returnSelectedGarment = $garment;
            $this->returnSelectedGarmentId = $garment->id;
            
            // Ambil nama dari relasi employee
            $employeeName = $garment->garment->name ?? $garment->name ?? '-';
            $employeeNik = $garment->garment->nik ?? '-';
            
            $this->returnGarmentSearch = $employeeName . ' (' . $employeeNik . ')';
            $this->returnShowGarmentList = false;
            
            $this->dispatch('notify', message: 'Data pengukuran selected!', type: 'success');
        }
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

        if ($this->returnTransaction->employee) {
            $employeeId = $this->returnTransaction->employee->id;
            $employeeNik = $this->returnTransaction->employee->nik;
            $employeeName = $this->returnTransaction->employee->name;
            
            // Cari data garment dan urutkan dari yang terbaru
            $garments = GarmentDetail::where('nik', $employeeId)
                ->orderBy('next_date', 'DESC') // Urutkan dari yang paling baru
                ->get();
            
            if ($garments->count() > 0) {
                // Pilih yang paling baru (pertama setelah diurutkan DESC)
                $this->returnSelectedGarment = $garments->first();
                $this->returnSelectedGarmentId = $this->returnSelectedGarment->id;
                $this->returnGarmentSearch = $employeeName . ' (' . $employeeNik . ')';
                $this->returnShowGarmentList = false;
                
                // Simpan semua data untuk ditampilkan di list
                $this->returnGarmentResults = $garments;
                $this->returnShowGarmentList = true; // Tampilkan list agar user bisa pilih yang lain
                
                $this->dispatch('notify', message: 'Data pengukuran ditemukan! Yang terbaru otomatis dipilih.', type: 'success');
            } else {
                $this->returnGarmentSearch = $employeeNik;
                $this->returnGarmentResults = collect();
                $this->returnShowGarmentList = true;
                $this->dispatch('notify', message: 'Data pengukuran tidak ditemukan untuk karyawan ini.', type: 'warning');
            }
        }

        $this->returnStep = 2;
    }

    public function returnUniform()
    {
        // Validasi harus pilih data pengukuran
        if (!$this->returnSelectedGarment) {
            $this->dispatch('notify', message: 'Please select measurement data first!', type: 'error');
            return;
        }

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
                'stored_at' => now(),
                'garment_detail_id' => $this->returnSelectedGarment->id // Simpan ID garment di transaction
            ]);

            $locker->update([
                'status' => 'finished'
            ]);

            // ============ SCHEDULE AUTO CLOSE ============
            dispatch(new \App\Jobs\AutoCloseLockerJob($locker->id))->delay(now()->addSeconds(15));
            // =============================================

            // Kirim Email dengan QR Code dan Data Pengukuran
            $this->sendReturnEmailWithQRAndMeasurement($this->returnTransaction, $this->returnSelectedGarment);

            $this->dispatch('open-locker', ['code' => $locker->code]);

            $this->returnStep = 3;
            $this->dispatch('notify', message: 'Locker opened successfully! Uniform has been returned and marked as Finished.', type: 'success');
        });

        $this->returnIsLoading = false;
    }

    // ============ KIRIM EMAIL DENGAN ACCESS CODE & QR CODE & DATA PENGUKURAN ============
    protected function sendReturnEmailWithQRAndMeasurement($transaction, $garmentData)
    {
        try {
            $employee = $transaction->employee;
            $locker = $transaction->locker;
            $email = $transaction->email;
            
            if (!$email) {
                Log::error('No email for Return with QR and Measurement', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            $data = [
                'employee_name' => $employee->name,
                'nik' => $employee->nik,
                'locker_code' => $locker->code,
                'access_code' => $transaction->access_code,
                'type' => 'ready_with_measurement',
                'status' => 'Siap Diambil',
                'datetime' => now()->format('d/m/Y H:i'),
                'garment_data' => $garmentData ? [
                    'd1' => $garmentData->d1,
                    'd1_scientific' => $garmentData->d1_scientific,
                    'judgement_d1' => $garmentData->judgement_d1,
                    'd2' => $garmentData->d2,
                    'd2_scientific' => $garmentData->d2_scientific,
                    'judgement_d2' => $garmentData->judgement_d2,
                    'd3' => $garmentData->d3,
                    'd3_scientific' => $garmentData->d3_scientific,
                    'judgement_d3' => $garmentData->judgement_d3,
                    'd4' => $garmentData->d4,
                    'd4_scientific' => $garmentData->d4_scientific,
                    'judgement_d4' => $garmentData->judgement_d4,
                    'next_date' => $garmentData->next_date,
                    'remarks' => $garmentData->remarks,
                ] : null
            ];

            Mail::to($email)->send(new \App\Mail\ESD\LockerNotificationMail($data));
            
            Log::info('Email Return (Ready with Measurement) sent successfully', [
                'transaction_id' => $transaction->id,
                'email' => $email,
                'access_code' => $transaction->access_code,
                'has_garment_data' => !is_null($garmentData),
                'garment_detail_id' => $garmentData->id ?? null
            ]);
            
        } catch (\Exception $e) {
            Log::error('Email Return with Measurement send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }

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

                // Kirim Email NG
                $this->sendNgEmail($transaction);
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

    protected function sendNgEmail($transaction)
    {
        try {
            $employee = $transaction->employee;
            $email = $transaction->email;
            
            if (!$email) {
                Log::error('No email for NG', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            $data = [
                'employee_name' => $employee->name,
                'nik' => $employee->nik,
                'locker_code' => $transaction->locker->code,
                'type' => 'ng',
                'status' => 'NG (Tidak Lolos Pengecekan)',
                'datetime' => now()->format('d/m/Y H:i'),
                'notes' => $transaction->notes ?? 'Tidak ada keterangan'
            ];

            Mail::to($email)->send(new \App\Mail\ESD\LockerNotificationMail($data));
            
            Log::info('Email NG sent successfully', [
                'transaction_id' => $transaction->id,
                'email' => $email
            ]);
        } catch (\Exception $e) {
            Log::error('Email NG send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }

    // ============ VIEW ACTIVITY ============
    public function viewActivity($id)
    {
        $this->selectedLockerForActivity = Locker::find($id);
        $this->activityPage = 1;
        $this->showActivityModal = true;
    }

    public function setActivityPage($page)
    {
        $this->activityPage = max(1, $page);
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

                // Kirim Email
                $this->sendNgEmail($transaction);
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
        // ============ HITUNG STATS ============
        $stats = [
            'total' => Locker::count(),
            'available' => Locker::available()->count(),
            'open' => Locker::open()->count(),
            'in_progress' => Locker::inProgress()->count(),
            'ng' => Locker::ng()->count(),
            'finished' => Locker::finished()->count(),
            'transactions_active' => UniformTransaction::whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])->count()
        ];

        // Get left lockers (1-10)
        $leftLockers = Locker::with('employee')
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('dept', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterDept, function ($query) {
                $query->where('dept', 'like', '%' . $this->filterDept . '%');
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('updated_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('updated_at', '<=', $this->filterDateUntil);
            })
            ->whereBetween('id', [1, 10])
            ->orderBy('id', 'asc')
            ->get();

        // Get right lockers (11-20)
        $rightLockers = Locker::with('employee')
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('dept', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterDept, function ($query) {
                $query->where('dept', 'like', '%' . $this->filterDept . '%');
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('updated_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('updated_at', '<=', $this->filterDateUntil);
            })
            ->whereBetween('id', [11, 20])
            ->orderBy('id', 'asc')
            ->get();

        // All lockers for count
        $allLockers = Locker::when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('dept', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterDept, function ($query) {
                $query->where('dept', 'like', '%' . $this->filterDept . '%');
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('updated_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('updated_at', '<=', $this->filterDateUntil);
            })
            ->get();

        // Gabungkan semua locker untuk ditampilkan di grid
        $lockers = Locker::with('employee')
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('dept', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterDept, function ($query) {
                $query->where('dept', 'like', '%' . $this->filterDept . '%');
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('updated_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('updated_at', '<=', $this->filterDateUntil);
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('livewire.esd.locker.locker-management', [
            'leftLockers' => $leftLockers,
            'rightLockers' => $rightLockers,
            'allLockers' => $allLockers,
            'lockers' => $lockers,
            'stats' => $stats
        ]);
    }
}