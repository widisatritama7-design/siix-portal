<?php

namespace App\Livewire\PROD\Uniform;

use App\Mail\PROD\AdminFeedbackImportedMail;
use App\Mail\PROD\CostingFeedbackImportedMail;
use App\Models\HR\Employee;
use App\Models\PROD\Uniform\MasterUniform;
use App\Models\PROD\Uniform\UniformRequest;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UniformRequestShow extends Component
{
    use WithFileUploads, WithPagination;
    
    public $request;
    public $requestId;
    public $selectedRowIndex = null;
    public $selectedFeedbackType = null;
    public $feedback_input = '';
    public $modalTitle = '';
    public $showModal = false;
    public $page = 1;
    public $perPage = 5;
    
    // Import properties
    public $importFile = null;
    public $showImportModal = false;
    public $importType = null; // 'admin' or 'costing'
    public $importPreview = [];
    public $importErrors = [];
    public $importSuccessCount = 0;
    public $importFailCount = 0;

    // Verification properties
    public $showVerificationModal = false;
    public $verificationRowIndex = null;
    public $verificationStatus = null; // 'approved' or 'rejected'
    public $verificationNote = '';
    public $verificationItem = null;

    // Digital Signature properties
    public $showSignatureModal = false;
    public $signatureRowIndex = null;
    public $signatureName = '';
    public $signaturePosition = '';
    public $signatureItem = null;
    public $signatureImage = null; // Base64 image data from canvas

    // Salary Deduction properties
    public $showSalaryModal = false;
    public $salaryRowIndex = null;
    public $salaryItem = null;
    public $salaryDeduction = 'no'; // 'yes' or 'no'
    public $salaryAmount = null;
    public $payrollPeriod = '';
    public $payrollMonth = '';
    public $payrollYear = '';
    public $availableYears = [];
    public $availableMonths = [];

    public $showBulkDepartmentModal = false;
    public $bulkDepartment = '';
    public $bulkManualItems = [];
    public $selectedItems = []; // Array untuk menyimpan item yang dipilih

    // Tambahkan properties baru di bagian atas class
    public $showBulkCostingModal = false;
    public $bulkCostingItems = [];
    public $selectedCostingItems = [];
    public $bulkCostingAction = ''; // 'waiting', 'stock_manual', 'missc'

    protected $listeners = ['refreshTable' => '$refresh'];

    public function resetPage()
    {
        $this->page = 1;
    }

    public function mount($id)
    {
        $this->requestId = $id;
        $this->request = UniformRequest::with('creator')->find($id);
        
        if (!$this->request) {
            session()->flash('error', 'Request not found!');
            return redirect()->route('prod.uniform.request.index');
        }
    }

    public function openBulkCostingModal()
    {
        // Debug: Log untuk cek
        \Log::info('openBulkCostingModal called by: ' . auth()->user()->name);
        
        // Cek permission
        if (!auth()->user()->can('feedback uniform request costing')) {
            session()->flash('error', 'You do not have permission to update costing!');
            return;
        }
        
        // Ambil items yang BUTUH COSTING (approved/manual tapi belum final)
        $costingItems = $this->items_detail->filter(function($item) {
            // Skip rejected items
            if (isset($item['verification_status']) && $item['verification_status'] === 'rejected') {
                return false;
            }
            
            // Skip jika sudah final (stock_manual atau missc)
            $costingAction = $item['costing_action'] ?? null;
            if (in_array($costingAction, ['stock_manual', 'missc'])) {
                return false;
            }
            
            // Hanya item yang sudah approved atau manual
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            $isApproved = isset($item['verification_status']) && $item['verification_status'] === 'approved';
            
            if (!$isManual && !$isApproved) {
                return false;
            }
            
            // Debug: Log item yang lolos
            \Log::info('Item lolos: ' . $item['item_code'] . ' - Manual: ' . ($isManual ? 'Yes' : 'No') . ' - Approved: ' . ($isApproved ? 'Yes' : 'No'));
            
            return true;
        })->values()->toArray();
        
        // Debug: Log jumlah
        \Log::info('Jumlah costingItems: ' . count($costingItems));
        
        if (empty($costingItems)) {
            session()->flash('error', 'No items need costing action!');
            return;
        }
        
        $this->selectedCostingItems = [];
        $this->bulkCostingItems = $costingItems;
        $this->bulkCostingAction = '';
        $this->showBulkCostingModal = true;
    }

    public function toggleSelectAllCosting()
    {
        $allIndices = collect($this->bulkCostingItems)->pluck('index')->toArray();
        
        if (count($this->selectedCostingItems) === count($allIndices)) {
            $this->selectedCostingItems = [];
        } else {
            $this->selectedCostingItems = $allIndices;
        }
    }

    public function toggleSelectCostingItem($index)
    {
        if (in_array($index, $this->selectedCostingItems)) {
            $this->selectedCostingItems = array_values(array_diff($this->selectedCostingItems, [$index]));
        } else {
            $this->selectedCostingItems[] = $index;
        }
    }

    public function saveBulkCosting()
    {
        if (empty($this->bulkCostingAction)) {
            session()->flash('error', 'Please select an action!');
            return;
        }
        
        if (empty($this->selectedCostingItems)) {
            session()->flash('error', 'Please select at least one item!');
            return;
        }
        
        $items = $this->request->items;
        $updatedCount = 0;
        $updatedItems = [];
        $skippedCount = 0;
        $skippedItems = [];
        $currentDateTime = now()->toDateTimeString();
        $currentUser = auth()->user()->name;
        
        // Map action ke feedback text
        $actionMap = [
            'waiting' => 'Waiting List',
            'stock_manual' => 'Create Stock Manual',
            'missc' => 'Create Missc'
        ];
        
        $feedbackText = $actionMap[$this->bulkCostingAction] ?? $this->bulkCostingAction;
        
        foreach ($this->bulkCostingItems as $costingItem) {
            $index = $costingItem['index'];
            
            if (in_array($index, $this->selectedCostingItems) && isset($items[$index])) {
                // Cek apakah item masih Waiting List (bisa diedit)
                $currentAction = $items[$index]['costing_action'] ?? null;
                
                if (in_array($currentAction, ['stock_manual', 'missc'])) {
                    // Skip item yang sudah final
                    $skippedCount++;
                    $skippedItems[] = $costingItem['employee_name'] . ' (' . $costingItem['item_code'] . ')';
                    continue;
                }
                
                // Update costing feedback
                $items[$index]['costing_feedback'] = $feedbackText;
                $items[$index]['costing_feedback_datetime'] = $currentDateTime;
                $items[$index]['costing_feedback_by'] = $currentUser;
                $items[$index]['costing_action'] = $this->bulkCostingAction;
                $updatedCount++;
                $updatedItems[] = $costingItem['employee_name'] . ' (' . $costingItem['item_code'] . ') → ' . $feedbackText;
            }
        }
        
        if ($updatedCount === 0 && $skippedCount === 0) {
            session()->flash('error', 'No items were updated!');
            return;
        }
        
        $this->request->update(['items' => $items]);
        $this->request = UniformRequest::with('creator')->find($this->requestId);
        
        $message = "Successfully updated {$updatedCount} item(s)";
        if (!empty($updatedItems)) {
            $message .= ": " . implode(', ', $updatedItems);
        }
        if ($skippedCount > 0) {
            $message .= ". Skipped {$skippedCount} finalized item(s): " . implode(', ', $skippedItems);
        }
        
        session()->flash('success', $message);
        
        $this->closeBulkCostingModal();
    }

    public function closeBulkCostingModal()
    {
        $this->showBulkCostingModal = false;
        $this->bulkCostingItems = [];
        $this->selectedCostingItems = [];
        $this->bulkCostingAction = '';
    }

    // ==================== SALARY DEDUCTION FUNCTIONS ====================

    public function openSalaryModal($rowIndex)
    {
        // Hanya admin yang bisa akses
        if (!auth()->user()->can('feedback uniform request admin')) {
            session()->flash('error', 'You do not have permission to manage salary deduction!');
            return;
        }

        $items = $this->items_detail;
        if (!isset($items[$rowIndex])) {
            session()->flash('error', 'Item not found!');
            return;
        }

        $item = $items[$rowIndex];
        
        // Cek apakah item rejected
        if (isset($item['verification_status']) && $item['verification_status'] === 'rejected') {
            session()->flash('error', 'Cannot set salary deduction for rejected item!');
            return;
        }
        
        // Cek apakah semua kondisi terpenuhi:
        if (empty($item['admin_feedback'])) {
            session()->flash('error', 'Admin feedback must be filled first!');
            return;
        }
        
        if (empty($item['verification_status'])) {
            session()->flash('error', 'Item must be verified first!');
            return;
        }
        
        if ($item['verification_status'] === 'approved' && empty($item['costing_feedback'])) {
            session()->flash('error', 'Costing feedback must be filled first!');
            return;
        }
        
        if (empty($item['digital_signature'])) {
            session()->flash('error', 'Item must be signed first!');
            return;
        }

        // Cari harga dari MasterUniform berdasarkan item_code
        $uniform = MasterUniform::where('item_code', $item['item_code'])->first();
        $this->salaryAmount = $uniform ? $uniform->price : 0;

        // Set data salary deduction yang sudah ada atau default
        $this->salaryDeduction = $item['salary_deduction'] ?? 'no';
        
        // Set periode dari data yang sudah ada atau auto generate (HANYA JIKA YES)
        if ($this->salaryDeduction === 'yes') {
            if (!empty($item['payroll_period'])) {
                $parts = explode('-', $item['payroll_period']);
                $this->payrollYear = $parts[0] ?? date('Y');
                $this->payrollMonth = $parts[1] ?? date('m');
                $this->payrollPeriod = $item['payroll_period'];
            } else {
                // Auto-generate period based on signature date
                $this->autoGeneratePeriod($item);
            }
        } else {
            // Jika No, period kosong
            $this->payrollPeriod = null;
            $this->payrollYear = '';
            $this->payrollMonth = '';
        }

        // Generate available years (5 tahun kebelakang)
        $this->availableYears = [];
        $currentYear = (int) date('Y');
        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - $i;
            $this->availableYears[] = $year;
        }

        // Generate available months
        $this->availableMonths = [
            ['value' => '01', 'label' => 'January'],
            ['value' => '02', 'label' => 'February'],
            ['value' => '03', 'label' => 'March'],
            ['value' => '04', 'label' => 'April'],
            ['value' => '05', 'label' => 'May'],
            ['value' => '06', 'label' => 'June'],
            ['value' => '07', 'label' => 'July'],
            ['value' => '08', 'label' => 'August'],
            ['value' => '09', 'label' => 'September'],
            ['value' => '10', 'label' => 'October'],
            ['value' => '11', 'label' => 'November'],
            ['value' => '12', 'label' => 'December'],
        ];

        $this->salaryRowIndex = $rowIndex;
        $this->salaryItem = $item;
        $this->showSalaryModal = true;
    }

    /**
     * Auto generate payroll period based on signature date
     * Rule: 18 May - 17 June 2026 = June 2026
     *       18 June - 17 July 2026 = July 2026
     */
    private function autoGeneratePeriod($item)
    {
        $signatureDate = null;
        
        // Get signature date from item
        if (!empty($item['signature_datetime'])) {
            $signatureDate = \Carbon\Carbon::parse($item['signature_datetime']);
        } else {
            // Jika belum ada signature, gunakan tanggal sekarang
            $signatureDate = now();
        }
        
        $day = (int) $signatureDate->format('d');
        
        // Rule: Jika tanggal 18-31, periode = bulan depan
        //        Jika tanggal 1-17, periode = bulan ini
        if ($day >= 18) {
            // Bulan depan
            $nextMonth = $signatureDate->copy()->addMonth();
            $this->payrollYear = $nextMonth->format('Y');
            $this->payrollMonth = $nextMonth->format('m');
        } else {
            // Bulan ini
            $this->payrollYear = $signatureDate->format('Y');
            $this->payrollMonth = $signatureDate->format('m');
        }
        
        $this->payrollPeriod = $this->payrollYear . '-' . $this->payrollMonth;
    }

    public function saveSalaryDeduction()
    {
        // Validasi index
        if ($this->salaryRowIndex === null) {
            session()->flash('error', 'Invalid data!');
            return;
        }

        $items = $this->request->items;
        $index = $this->salaryRowIndex;

        if (!isset($items[$index])) {
            session()->flash('error', 'Item not found!');
            return;
        }

        // Cek apakah item rejected
        $itemDetail = $this->items_detail[$this->salaryRowIndex] ?? null;
        if ($itemDetail && isset($itemDetail['verification_status']) && $itemDetail['verification_status'] === 'rejected') {
            session()->flash('error', 'Cannot save salary deduction for rejected item!');
            return;
        }

        // Validasi status deduction
        if (empty($this->salaryDeduction)) {
            session()->flash('error', 'Please select deduction status!');
            return;
        }

        // Jika deduction = yes, ambil amount dari MasterUniform
        if ($this->salaryDeduction === 'yes') {
            // Ambil item_detail untuk mendapatkan item_code
            if ($itemDetail) {
                $uniform = MasterUniform::where('item_code', $itemDetail['item_code'])->first();
                $this->salaryAmount = $uniform ? $uniform->price : 0;
            }

            // Validasi amount tidak boleh 0
            if (empty($this->salaryAmount) || $this->salaryAmount <= 0) {
                session()->flash('error', 'Price not found in Master Uniform! Please check item configuration.');
                return;
            }

            // Auto generate period jika belum ada
            if (empty($this->payrollPeriod)) {
                $this->autoGeneratePeriod($itemDetail ?? []);
            } else {
                // Format periode: YYYY-MM
                $this->payrollPeriod = $this->payrollYear . '-' . $this->payrollMonth;
            }
        } else {
            // Jika NO, reset period dan amount
            $this->payrollPeriod = null;
            $this->salaryAmount = null;
            $this->payrollYear = '';
            $this->payrollMonth = '';
        }

        // Simpan data ke items
        $items[$index]['salary_deduction'] = $this->salaryDeduction;
        $items[$index]['deduction_amount'] = $this->salaryDeduction === 'yes' ? (float) $this->salaryAmount : null;
        $items[$index]['payroll_period'] = $this->payrollPeriod;
        $items[$index]['salary_updated_by'] = auth()->user()->name;
        $items[$index]['salary_updated_at'] = now()->toDateTimeString();

        $this->request->update(['items' => $items]);
        
        session()->flash('success', 'Salary deduction settings saved successfully!');

        $this->closeSalaryModal();
        $this->request = UniformRequest::with('creator')->find($this->requestId);
    }

    public function closeSalaryModal()
    {
        $this->showSalaryModal = false;
        $this->salaryRowIndex = null;
        $this->salaryItem = null;
        $this->salaryDeduction = 'no';
        $this->salaryAmount = null;
        $this->payrollPeriod = '';
        $this->payrollMonth = '';
        $this->payrollYear = '';
        $this->availableYears = [];
        $this->availableMonths = [];
    }

    // ==================== BULK DEPARTMENT FUNCTIONS ====================

    public function openBulkDepartmentModal()
    {
        // Ambil manual items yang sudah signed
        $manualItems = $this->items_detail->filter(function($item) {
            return isset($item['is_manual']) && 
                $item['is_manual'] && 
                !empty($item['digital_signature']);
        })->values()->toArray();
        
        if (empty($manualItems)) {
            session()->flash('error', 'No manual items with signature found!');
            return;
        }
        
        // JANGAN AUTO SELECT - biarkan kosong
        $this->selectedItems = [];
        $this->bulkManualItems = $manualItems;
        $this->bulkDepartment = '';
        $this->showBulkDepartmentModal = true;
    }

    public function toggleSelectAll()
    {
        $allIndices = collect($this->bulkManualItems)->pluck('index')->toArray();
        
        // Jika semua sudah terpilih, unselect semua
        if (count($this->selectedItems) === count($allIndices)) {
            $this->selectedItems = [];
        } else {
            $this->selectedItems = $allIndices;
        }
    }

    public function toggleSelectItem($index)
    {
        if (in_array($index, $this->selectedItems)) {
            $this->selectedItems = array_values(array_diff($this->selectedItems, [$index]));
        } else {
            $this->selectedItems[] = $index;
        }
    }

    public function saveBulkDepartment()
    {
        if (empty($this->bulkDepartment)) {
            session()->flash('error', 'Please enter a department!');
            return;
        }
        
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Please select at least one item!');
            return;
        }
        
        $items = $this->request->items;
        $updatedCount = 0;
        $updatedItems = [];
        
        foreach ($this->bulkManualItems as $manualItem) {
            $index = $manualItem['index'];
            
            // Hanya update yang terpilih
            if (in_array($index, $this->selectedItems) && isset($items[$index])) {
                $items[$index]['manual_department'] = $this->bulkDepartment;
                $items[$index]['bulk_updated_at'] = now()->toDateTimeString();
                $items[$index]['bulk_updated_by'] = auth()->user()->name;
                $updatedCount++;
                $updatedItems[] = $manualItem['employee_name'] . ' (' . $manualItem['item_code'] . ')';
            }
        }
        
        if ($updatedCount === 0) {
            session()->flash('error', 'No items were updated!');
            return;
        }
        
        $this->request->update(['items' => $items]);
        $this->request = UniformRequest::with('creator')->find($this->requestId);
        
        session()->flash('success', "Successfully updated department for {$updatedCount} manual item(s): " . implode(', ', $updatedItems));
        
        $this->closeBulkDepartmentModal();
    }

    public function closeBulkDepartmentModal()
    {
        $this->showBulkDepartmentModal = false;
        $this->bulkDepartment = '';
        $this->bulkManualItems = [];
        $this->selectedItems = [];
    }

    // ==================== VERIFICATION FUNCTIONS ====================

    public function openVerificationModal($rowIndex)
    {
        if (!auth()->user()->can('verify uniform request')) {
            session()->flash('error', 'You do not have permission to verify!');
            return;
        }

        $items = $this->items_detail;
        if (!isset($items[$rowIndex])) {
            session()->flash('error', 'Item not found!');
            return;
        }

        $item = $items[$rowIndex];
        
        // Check if admin feedback exists
        if (empty($item['admin_feedback'])) {
            session()->flash('error', 'Admin feedback must be filled before verification!');
            return;
        }

        // Check if already verified
        if (!empty($item['verification_status'])) {
            session()->flash('error', 'This item has already been verified!');
            return;
        }

        // Cek jika item manual, skip verifikasi
        if (isset($item['is_manual']) && $item['is_manual']) {
            session()->flash('error', 'Manual items do not require verification!');
            return;
        }

        $this->verificationRowIndex = $rowIndex;
        $this->verificationItem = $item;
        $this->verificationStatus = null;
        $this->verificationNote = '';
        $this->showVerificationModal = true;
    }

    public function saveVerification()
    {
        if ($this->verificationRowIndex === null || !$this->verificationStatus) {
            session()->flash('error', 'Please select verification status!');
            return;
        }

        $items = $this->request->items;
        $index = $this->verificationRowIndex;

        if (!isset($items[$index])) {
            session()->flash('error', 'Item not found!');
            return;
        }

        // Ambil item detail untuk mendapatkan qty dan data employee
        $itemDetail = $this->items_detail[$this->verificationRowIndex] ?? null;
        $previousStatus = $items[$index]['verification_status'] ?? null;
        
        // Simpan verification
        $items[$index]['verification_status'] = $this->verificationStatus;
        $items[$index]['verification_datetime'] = now()->toDateTimeString();
        $items[$index]['verification_by'] = auth()->user()->name;
        $items[$index]['verification_note'] = $this->verificationNote;

        $this->request->update(['items' => $items]);
        
        // ==================== HANDLE STOCK RETURN IF REJECTED ====================
        $qtyRequested = 0;
        if ($this->verificationStatus === 'rejected' && $previousStatus !== 'rejected') {
            $qtyRequested = (int) ($itemDetail['qty'] ?? 0);
            $uniformId = $itemDetail['master_uniform_id'] ?? null;
            
            $employeeNik = $itemDetail['employee_nik'] ?? '-';
            $employeeName = $itemDetail['employee_name'] ?? '-';
            $employeeDepartment = $itemDetail['employee_department'] ?? '-';
            $employeeInfo = $employeeNik . ' - ' . $employeeName . ' (' . $employeeDepartment . ')';
            
            if ($uniformId && $qtyRequested > 0) {
                $uniform = MasterUniform::find($uniformId);
                if ($uniform) {
                    $oldQty = $uniform->qty;
                    $newQty = $oldQty + $qtyRequested;
                    
                    $uniform->qty = $newQty;
                    $uniform->save();
                    
                    try {
                        \App\Models\PROD\Uniform\UniformStockTransaction::create([
                            'master_uniform_id' => $uniform->id,
                            'transaction_type' => 'IN',
                            'qty_change' => $qtyRequested,
                            'qty_before' => $oldQty,
                            'qty_after' => $newQty,
                            'reference_id' => $this->request->request_number,
                            'reference_type' => 'uniform_request_rejected',
                            'description' => 'Pengembalian Uniform After Rejected - Request: ' . $this->request->request_number . ' - ' . $employeeInfo,
                            'performed_by' => auth()->user()->name,
                            'performed_at' => now(),
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to create stock return transaction: ' . $e->getMessage());
                    }
                }
            }
        }
        // ==================== END HANDLE STOCK RETURN ====================
        
        $statusText = $this->verificationStatus === 'approved' ? 'Approved' : 'Rejected';
        $message = "Item has been {$statusText} successfully!";
        
        if ($this->verificationStatus === 'rejected') {
            $items[$index]['costing_feedback'] = 'Rejected';
            $items[$index]['costing_feedback_datetime'] = now()->toDateTimeString();
            $items[$index]['costing_feedback_by'] = auth()->user()->name;
            $items[$index]['costing_action'] = 'rejected';
            $this->request->update(['items' => $items]);
        }
        
        session()->flash('success', $message);

        $this->closeVerificationModal();
        
        // ==================== REFRESH DATA ====================
        // Refresh request data dari database
        $this->request = UniformRequest::with('creator')->find($this->requestId);
        
        // Dispatch event untuk refresh table
        $this->dispatch('refreshTable');
        // ==================== END REFRESH DATA ====================
    }

    public function closeVerificationModal()
    {
        $this->showVerificationModal = false;
        $this->verificationRowIndex = null;
        $this->verificationStatus = null;
        $this->verificationNote = '';
        $this->verificationItem = null;
    }

    // ==================== SIGNATURE FUNCTIONS ====================

    public function openSignatureModal($rowIndex)
    {
        if (!auth()->user()->can('sign uniform request')) {
            session()->flash('error', 'You do not have permission to sign!');
            return;
        }

        $items = $this->items_detail;
        if (!isset($items[$rowIndex])) {
            session()->flash('error', 'Item not found!');
            return;
        }

        $item = $items[$rowIndex];
        
        // CEK: Apakah item rejected?
        if (isset($item['verification_status']) && $item['verification_status'] === 'rejected') {
            session()->flash('error', 'Cannot sign rejected item!');
            return;
        }
        
        // CEK: Harus sudah ada costing feedback
        if (empty($item['costing_feedback'])) {
            session()->flash('error', 'Costing feedback must be filled before signing!');
            return;
        }
        
        // CEK: Harus sudah final (stock_manual atau missc), BUKAN Waiting List
        $costingAction = $item['costing_action'] ?? null;
        if (!in_array($costingAction, ['stock_manual', 'missc'])) {
            session()->flash('error', 'Cannot sign item with "Waiting List" status! Please update to final action (Stock Manual or Missc) first.');
            return;
        }

        // CEK: Apakah sudah di-sign?
        if (!empty($item['digital_signature'])) {
            session()->flash('error', 'This item has already been signed!');
            return;
        }

        $this->signatureRowIndex = $rowIndex;
        $this->signatureItem = $item;
        $this->signatureName = $item['employee_name'] ?? auth()->user()->name;
        $this->signaturePosition = auth()->user()->position ?? 'Staff';
        $this->signatureImage = null;
        $this->showSignatureModal = true;
    }

    public function saveSignature()
    {
        if ($this->signatureRowIndex === null) {
            session()->flash('error', 'Invalid signature data!');
            return;
        }

        if (empty($this->signatureName)) {
            session()->flash('error', 'Please enter your name!');
            return;
        }

        if (empty($this->signatureImage)) {
            session()->flash('error', 'Please provide your digital signature!');
            return;
        }

        $items = $this->request->items;
        $index = $this->signatureRowIndex;

        if (!isset($items[$index])) {
            session()->flash('error', 'Item not found!');
            return;
        }

        // CEK: Harus sudah final (stock_manual atau missc)
        $costingAction = $items[$index]['costing_action'] ?? null;
        if (!in_array($costingAction, ['stock_manual', 'missc'])) {
            session()->flash('error', 'Cannot sign item with "Waiting List" status! Please update to final action first.');
            return;
        }

        // CEK: Apakah sudah di-sign?
        if (!empty($items[$index]['digital_signature'])) {
            session()->flash('error', 'This item has already been signed!');
            return;
        }

        // Cek salary deduction status
        $salaryDeduction = $items[$index]['salary_deduction'] ?? 'no';
        
        // Hanya isi period jika salary_deduction = yes
        if ($salaryDeduction === 'yes') {
            // Auto generate payroll period based on signature date
            $this->autoGeneratePeriod($this->signatureItem);
            $items[$index]['payroll_period'] = $this->payrollPeriod;
            $items[$index]['payroll_year'] = $this->payrollYear;
            $items[$index]['payroll_month'] = $this->payrollMonth;
        } else {
            // Jika No, period tetap null
            $items[$index]['payroll_period'] = null;
            $items[$index]['payroll_year'] = null;
            $items[$index]['payroll_month'] = null;
        }

        $items[$index]['digital_signature'] = $this->signatureImage;
        $items[$index]['signature_datetime'] = now()->toDateTimeString();
        $items[$index]['signature_name'] = $this->signatureName;

        $this->request->update(['items' => $items]);
        
        // ==================== RECORD STOCK OUT ====================
        // Kurangi stock dari MasterUniform
        $uniform = MasterUniform::find($this->signatureItem['master_uniform_id']);
        if ($uniform) {
            $oldQty = $uniform->qty;
            $qtyRequested = (int) $this->signatureItem['qty'];
            $newQty = $oldQty - $qtyRequested;
            
            // Pastikan stock tidak negatif (tapi tetap catat)
            if ($newQty < 0) {
                // Log warning tapi tetap lanjutkan
                \Log::warning('Stock negative for uniform: ' . $uniform->item_code . ' - Request: ' . $this->request->request_number . ' - Old: ' . $oldQty . ', Requested: ' . $qtyRequested);
                $newQty = 0;
            }
            
            // Update qty di MasterUniform
            $uniform->qty = $newQty;
            $uniform->save();
            
            // Ambil data employee untuk deskripsi
            $employeeNik = $this->signatureItem['employee_nik'] ?? '-';
            $employeeName = $this->signatureItem['employee_name'] ?? '-';
            $employeeDepartment = $this->signatureItem['employee_department'] ?? '-';
            $employeeInfo = $employeeNik . ' - ' . $employeeName . ' (' . $employeeDepartment . ')';
            
            // Create transaction history
            try {
                \App\Models\PROD\Uniform\UniformStockTransaction::create([
                    'master_uniform_id' => $uniform->id,
                    'transaction_type' => 'OUT',
                    'qty_change' => -$qtyRequested,
                    'qty_before' => $oldQty,
                    'qty_after' => $newQty,
                    'reference_id' => $this->request->request_number,
                    'reference_type' => 'uniform_request',
                    'description' => 'Request: ' . $this->request->request_number . ' - ' . $employeeInfo,
                    'performed_by' => auth()->user()->name,
                    'performed_at' => now(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to create stock transaction: ' . $e->getMessage());
            }
        } else {
            \Log::warning('Uniform not found for stock deduction: ' . ($this->signatureItem['master_uniform_id'] ?? 'null'));
        }
        // ==================== END RECORD STOCK OUT ====================
        
        $message = 'Digital signature has been applied successfully!';
        if ($salaryDeduction === 'yes') {
            $message .= ' Payroll period: ' . \Carbon\Carbon::parse($this->payrollPeriod . '-01')->format('F Y');
        } else {
            $message .= ' (No salary deduction)';
        }
        
        // Tambahkan info stock ke message
        if ($uniform) {
            $message .= ' Stock remaining: ' . $uniform->qty;
            if ($uniform->qty <= 5 && $uniform->qty > 0) {
                $message .= ' (Low stock!)';
            } elseif ($uniform->qty == 0) {
                $message .= ' (Out of stock!)';
            }
        }
        
        session()->flash('success', $message);

        $this->closeSignatureModal();
        $this->request = UniformRequest::with('creator')->find($this->requestId);
    }

    public function closeSignatureModal()
    {
        $this->showSignatureModal = false;
        $this->signatureRowIndex = null;
        $this->signatureName = '';
        $this->signaturePosition = '';
        $this->signatureItem = null;
        $this->signatureImage = null;
    }

    // ==================== GET ITEMS DETAIL ====================

    public function getItemsDetailProperty()
    {
        $items = $this->request->items ?? [];
        $details = [];
        
        foreach ($items as $index => $item) {
            $employee = Employee::find($item['employee_id'] ?? null);
            $uniform = MasterUniform::find($item['master_uniform_id']);
            
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            
            // Jika manual, set admin_feedback, verification_status, salary_deduction ke N/A
            $adminFeedback = $item['admin_feedback'] ?? null;
            $verificationStatus = $item['verification_status'] ?? null;
            $salaryDeduction = $item['salary_deduction'] ?? null;
            $payrollPeriod = $item['payroll_period'] ?? null;
            $deductionAmount = $item['deduction_amount'] ?? null;
            
            if ($isManual) {
                $adminFeedback = 'N/A (Manual Input)';
                $verificationStatus = 'N/A (Manual Input)';
                $salaryDeduction = 'N/A (Manual Input)';
                $payrollPeriod = null;
                $deductionAmount = null;
            }
            
            $details[] = [
                'index' => $index,
                'employee_id' => $item['employee_id'] ?? null,
                'employee_name' => $isManual ? ($item['manual_name'] ?? '-') : ($employee->name ?? '-'),
                'employee_nik' => $isManual ? ($item['manual_nik'] ?? '-') : ($employee->nik ?? '-'),
                'employee_department' => $isManual ? ($item['manual_department'] ?? '-') : ($employee->department ?? '-'),
                'master_uniform_id' => $item['master_uniform_id'],
                'item_code' => $uniform->item_code ?? '-',
                'description' => $uniform->description ?? '-',
                'size' => $uniform->size ?? '-',
                'qty' => $item['qty'],
                'reason' => $item['reason'],
                'group' => $item['group'],
                'request_date' => $item['request_date'],
                'remarks' => $item['remarks'] ?? '',
                // Admin Feedback
                'admin_feedback' => $adminFeedback,
                'admin_feedback_datetime' => $item['admin_feedback_datetime'] ?? null,
                'admin_feedback_by' => $item['admin_feedback_by'] ?? null,
                // Salary Deduction
                'salary_deduction' => $salaryDeduction,
                'deduction_amount' => $deductionAmount,
                'payroll_period' => $payrollPeriod,
                'payroll_year' => $item['payroll_year'] ?? null,
                'payroll_month' => $item['payroll_month'] ?? null,
                'salary_updated_by' => $item['salary_updated_by'] ?? null,
                'salary_updated_at' => $item['salary_updated_at'] ?? null,
                // Verification
                'verification_status' => $verificationStatus,
                'verification_datetime' => $item['verification_datetime'] ?? null,
                'verification_by' => $item['verification_by'] ?? null,
                'verification_note' => $item['verification_note'] ?? null,
                // Costing Feedback
                'costing_feedback' => $item['costing_feedback'] ?? null,
                'costing_feedback_datetime' => $item['costing_feedback_datetime'] ?? null,
                'costing_feedback_by' => $item['costing_feedback_by'] ?? null,
                'costing_action' => $item['costing_action'] ?? null, // <-- TAMBAHKAN INI
                // Digital Signature
                'digital_signature' => $item['digital_signature'] ?? null,
                'signature_datetime' => $item['signature_datetime'] ?? null,
                'signature_name' => $item['signature_name'] ?? null,
                'signature_position' => $item['signature_position'] ?? null,
                // Manual fields
                'is_manual' => $isManual,
                'manual_nik' => $item['manual_nik'] ?? null,
                'manual_name' => $item['manual_name'] ?? null,
                'manual_department' => $item['manual_department'] ?? null,
            ];
        }
        
        return collect($details);
    }

    // ==================== FEEDBACK FUNCTIONS ====================

    public function openAdminFeedbackModal($rowIndex)
    {
        if (!auth()->user()->can('feedback uniform request admin')) {
            session()->flash('error', 'You do not have permission to add admin feedback!');
            return;
        }

        $this->selectedRowIndex = $rowIndex;
        $this->selectedFeedbackType = 'admin';
        $this->feedback_input = '';
        $this->modalTitle = 'Add Admin Feedback';
        $this->showModal = true;
    }

    public function openCostingFeedbackModal($rowIndex)
    {
        if (!auth()->user()->can('feedback uniform request costing')) {
            session()->flash('error', 'You do not have permission to add costing feedback!');
            return;
        }

        $this->selectedRowIndex = $rowIndex;
        $this->selectedFeedbackType = 'costing';
        $this->feedback_input = '';
        $this->modalTitle = 'Add Costing Feedback';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedRowIndex = null;
        $this->selectedFeedbackType = null;
        $this->feedback_input = '';
    }

    public function saveFeedback()
    {
        if (!$this->feedback_input || $this->selectedRowIndex === null) {
            session()->flash('error', 'Please enter feedback!');
            return;
        }
        
        $items = $this->request->items;
        $currentUser = auth()->user()->name;
        
        if (isset($items[$this->selectedRowIndex])) {
            if ($this->selectedFeedbackType === 'admin') {
                $items[$this->selectedRowIndex]['admin_feedback'] = $this->feedback_input;
                $items[$this->selectedRowIndex]['admin_feedback_datetime'] = now()->toDateTimeString();
                $items[$this->selectedRowIndex]['admin_feedback_by'] = $currentUser;
                $message = 'Admin feedback added successfully!';
            } else {
                $items[$this->selectedRowIndex]['costing_feedback'] = $this->feedback_input;
                $items[$this->selectedRowIndex]['costing_feedback_datetime'] = now()->toDateTimeString();
                $items[$this->selectedRowIndex]['costing_feedback_by'] = $currentUser;
                $message = 'Costing feedback added successfully!';
            }
            
            $this->request->update(['items' => $items]);
            session()->flash('success', $message);
        }
        
        $this->closeModal();
        $this->request = UniformRequest::with('creator')->find($this->requestId);
        
        // Kirim email ke emails user
        try {
            $recipients = ['sek.esd@siix-global.com']; // Default
            
            // Ambil dari user created_by
            if ($this->request->created_by) {
                $user = \App\Models\User::where('name', $this->request->created_by)->first();
                if ($user && !empty($user->emails)) {
                    if (is_string($user->emails)) {
                        $recipients = array_map('trim', explode(',', $user->emails));
                    } elseif (is_array($user->emails)) {
                        $recipients = $user->emails;
                    }
                }
            }
            
            // Kirim email sesuai tipe feedback
            if ($this->selectedFeedbackType === 'admin') {
                Mail::to($recipients)->send(new AdminFeedbackImportedMail($this->request));
            } else {
                Mail::to($recipients)->send(new CostingFeedbackImportedMail($this->request));
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to send feedback email: ' . $e->getMessage());
        }
    }

    // ==================== EXPORT FUNCTIONS ====================

    public function exportAdminFeedback()
    {
        $items = $this->items_detail;
        
        $csvData = [];
        
        // Header Section
        $csvData[] = ['REQUEST NUMBER #', 'TOTAL EMPLOYEE', 'PREPARED BY', 'DATE'];
        $csvData[] = [
            $this->request->request_number, 
            count($items) . ' employee(s)', 
            $this->request->creator->name ?? '-', 
            $this->request->created_at ? $this->request->created_at->format('Y/m/d H:i') : '-'
        ];
        $csvData[] = [];
        $csvData[] = [];
        
        // Data Table Header - HAPUS PERIOD
        $csvData[] = [
            'NIK', 
            'NAME',
            'DEPARTMENT',
            'ITEM CODE', 
            'DESCRIPTION', 
            'SIZE', 
            'QTY', 
            'GROUP', 
            'REQUEST DATE', 
            'REASON', 
            'REMARKS',
            'ADMIN FEEDBACK',
            'SALARY DEDUCTION',
            'IS_MANUAL'
        ];
        
        // Data rows
        foreach ($items as $item) {
            // Tentukan nilai NIK, NAME, DEPARTMENT berdasarkan manual atau tidak
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            $nik = $isManual ? ($item['manual_nik'] ?? $item['employee_nik']) : $item['employee_nik'];
            $name = $isManual ? ($item['manual_name'] ?? $item['employee_name']) : $item['employee_name'];
            $department = $isManual ? ($item['manual_department'] ?? $item['employee_department']) : $item['employee_department'];
            
            $csvData[] = [
                $nik,
                $name,
                $department,
                $item['item_code'],
                $item['description'],
                $item['size'],
                $item['qty'],
                $item['group'],
                $item['request_date'],
                $item['reason'],
                $item['remarks'] ?? '',
                $item['admin_feedback'] ?? '',
                isset($item['salary_deduction']) ? ucfirst($item['salary_deduction']) : '',
                $isManual ? 'Yes' : 'No',
            ];
        }
        
        return $this->generateCSVResponse($csvData, 'admin_feedback_' . $this->request->request_number . '.csv');
    }

    public function exportCostingFeedback()
    {
        $items = $this->items_detail;
        
        $csvData = [];
        
        // Header Section
        $csvData[] = ['REQUEST NUMBER #', 'TOTAL EMPLOYEE', 'PREPARED BY', 'DATE'];
        $csvData[] = [
            $this->request->request_number, 
            count($items) . ' employee(s)', 
            $this->request->creator->name ?? '-', 
            $this->request->created_at ? $this->request->created_at->format('Y/m/d H:i') : '-'
        ];
        $csvData[] = [];
        $csvData[] = [];
        
        // Data Table Header
        $csvData[] = [
            'NIK', 
            'NAME',
            'DEPARTMENT',
            'ITEM CODE', 
            'DESCRIPTION', 
            'SIZE', 
            'QTY', 
            'GROUP', 
            'REQUEST DATE', 
            'REASON', 
            'REMARKS',
            'ADMIN FEEDBACK', 
            'ADMIN FEEDBACK DATE',
            'VERIFICATION STATUS', 
            'VERIFICATION DATE', 
            'VERIFIED BY', 
            'VERIFICATION NOTE',
            'COSTING FEEDBACK',
            'IS_MANUAL'
        ];
        
        // Data rows
        foreach ($items as $item) {
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            $nik = $isManual ? ($item['manual_nik'] ?? $item['employee_nik']) : $item['employee_nik'];
            $name = $isManual ? ($item['manual_name'] ?? $item['employee_name']) : $item['employee_name'];
            $department = $isManual ? ($item['manual_department'] ?? $item['employee_department']) : $item['employee_department'];
            
            $csvData[] = [
                $nik,
                $name,
                $department,
                $item['item_code'],
                $item['description'],
                $item['size'],
                $item['qty'],
                $item['group'],
                $item['request_date'],
                $item['reason'],
                $item['remarks'] ?? '',
                $item['admin_feedback'] ?? '',
                $item['admin_feedback_datetime'] ?? '',
                ucfirst($item['verification_status'] ?? ''),
                $item['verification_datetime'] ?? '',
                $item['verification_by'] ?? '',
                $item['verification_note'] ?? '',
                $item['costing_feedback'] ?? '',
                $isManual ? 'Yes' : 'No',
            ];
        }
        
        return $this->generateCSVResponse($csvData, 'costing_feedback_' . $this->request->request_number . '.csv');
    }

    private function generateCSVResponse($data, $filename)
    {
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            // Add BOM for UTF-8
            fputs($file, "\xEF\xBB\xBF");
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ==================== IMPORT FUNCTIONS ====================

    public function openImportModal($type)
    {
        if ($type === 'admin' && !auth()->user()->can('feedback uniform request admin')) {
            session()->flash('error', 'You do not have permission to import admin feedback!');
            return;
        }
        
        if ($type === 'costing' && !auth()->user()->can('feedback uniform request costing')) {
            session()->flash('error', 'You do not have permission to import costing feedback!');
            return;
        }
        
        $this->importType = $type;
        $this->importFile = null;
        $this->importPreview = [];
        $this->importErrors = [];
        $this->importSuccessCount = 0;
        $this->importFailCount = 0;
        $this->showImportModal = true;
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->importFile = null;
        $this->importPreview = [];
        $this->importErrors = [];
        $this->importType = null;
    }

    private function cleanCsvValue($value)
    {
        if ($value === null) return '';
        
        $value = trim($value);
        if (strlen($value) >= 2) {
            if (($value[0] == '"' && $value[strlen($value)-1] == '"') || 
                ($value[0] == "'" && $value[strlen($value)-1] == "'")) {
                $value = substr($value, 1, -1);
            }
        }
        $value = str_replace("\xEF\xBB\xBF", '', $value);
        return $value;
    }

    public function previewImport()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt|max:2048'
        ]);
        
        $fileContent = file_get_contents($this->importFile->getRealPath());
        
        // Auto-detect delimiter
        $lines = explode("\n", $fileContent);
        $firstLine = isset($lines[0]) ? $lines[0] : '';
        
        $delimiter = ',';
        if (strpos($firstLine, "\t") !== false) {
            $delimiter = "\t";
        } elseif (strpos($firstLine, ';') !== false) {
            $delimiter = ';';
        }
        
        // Parse CSV file with detected delimiter
        $csvData = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;
            
            $row = str_getcsv($line, $delimiter);
            
            $cleanedRow = array_map(function($value) {
                $value = trim($value);
                if (strlen($value) >= 2) {
                    if (($value[0] == '"' && $value[strlen($value)-1] == '"') || 
                        ($value[0] == "'" && $value[strlen($value)-1] == "'")) {
                        $value = substr($value, 1, -1);
                    }
                }
                return $value;
            }, $row);
            
            $hasData = false;
            foreach ($cleanedRow as $cell) {
                if (!empty($cell) && $cell !== '-') {
                    $hasData = true;
                    break;
                }
            }
            if ($hasData) {
                $csvData[] = $cleanedRow;
            }
        }
        
        if (count($csvData) < 2) {
            session()->flash('error', 'CSV file is empty or invalid! Detected delimiter: ' . $delimiter);
            return;
        }
        
        // Find header row - look for NIK column
        $headerRowIndex = null;
        $headerRowData = null;
        
        for ($i = 0; $i < min(10, count($csvData)); $i++) {
            if (!isset($csvData[$i][0])) continue;
            
            foreach ($csvData[$i] as $cellIndex => $cell) {
                $cleanedCell = strtoupper(trim(preg_replace('/[^A-Za-z0-9]/', '', $cell)));
                if ($cleanedCell == 'NIK') {
                    $headerRowIndex = $i;
                    $headerRowData = $csvData[$i];
                    break 2;
                }
            }
        }
        
        if ($headerRowIndex === null) {
            session()->flash('error', 'Cannot find header row with NIK column!');
            return;
        }
        
        // Get headers and normalize
        $headers = $headerRowData;
        $normalizedHeaders = [];
        
        foreach ($headers as $header) {
            $normalized = strtoupper(trim(preg_replace('/[^A-Za-z0-9]/', ' ', $header)));
            $normalized = preg_replace('/\s+/', ' ', $normalized);
            $normalizedHeaders[] = trim($normalized);
        }
        
        // Expected headers based on import type
        if ($this->importType === 'admin') {
            // HAPUS PERIOD dari expected headers
            $expectedHeaders = [
                'NIK', 'NAME', 'DEPARTMENT', 'ITEM CODE', 'DESCRIPTION', 'SIZE', 'QTY', 
                'GROUP', 'REQUEST DATE', 'REASON', 'REMARKS',
                'ADMIN FEEDBACK', 'SALARY DEDUCTION'
            ];
        } else {
            $expectedHeaders = [
                'NIK', 'NAME', 'DEPARTMENT', 'ITEM CODE', 'DESCRIPTION', 'SIZE', 'QTY', 
                'GROUP', 'REQUEST DATE', 'REASON', 'REMARKS',
                'ADMIN FEEDBACK', 'ADMIN FEEDBACK DATE',
                'VERIFICATION STATUS', 'VERIFICATION DATE', 'VERIFIED BY', 'VERIFICATION NOTE',
                'COSTING FEEDBACK'
            ];
        }
        
        // Create column mapping with fuzzy matching
        $columnMapping = [];
        $missingHeaders = [];
        
        foreach ($expectedHeaders as $expectedHeader) {
            $found = false;
            $expectedNormalized = strtoupper(trim(preg_replace('/[^A-Za-z0-9]/', ' ', $expectedHeader)));
            $expectedNormalized = preg_replace('/\s+/', ' ', $expectedNormalized);
            
            foreach ($normalizedHeaders as $index => $normalizedHeader) {
                if ($normalizedHeader == $expectedNormalized) {
                    $columnMapping[$expectedHeader] = $index;
                    $found = true;
                    break;
                } elseif (strpos($normalizedHeader, $expectedNormalized) !== false || 
                        strpos($expectedNormalized, $normalizedHeader) !== false) {
                    $columnMapping[$expectedHeader] = $index;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $missingHeaders[] = $expectedHeader;
            }
        }
        
        if (!empty($missingHeaders)) {
            session()->flash('error', 'Missing headers: ' . implode(', ', $missingHeaders));
            return;
        }
        
        $this->importPreview = [];
        $this->importErrors = [];
        $this->importSuccessCount = 0;
        $this->importFailCount = 0;
        
        $itemsDetail = $this->items_detail;
        
        // Track item yang sudah di-match untuk menghindari duplikasi
        $matchedIndices = [];
        
        // Process data rows
        for ($i = $headerRowIndex + 1; $i < count($csvData); $i++) {
            $row = $csvData[$i];
            
            $hasData = false;
            foreach ($row as $cell) {
                $cell = trim($cell);
                if (!empty($cell) && $cell !== '-' && $cell !== '') {
                    $hasData = true;
                    break;
                }
            }
            if (!$hasData) continue;
            
            $rowNumber = $i + 1;
            
            // Extract data using column mapping
            $rowData = [];
            foreach ($columnMapping as $expectedHeader => $colIndex) {
                $value = isset($row[$colIndex]) ? trim($row[$colIndex]) : '';
                if (strlen($value) >= 2) {
                    if (($value[0] == '"' && $value[strlen($value)-1] == '"') || 
                        ($value[0] == "'" && $value[strlen($value)-1] == "'")) {
                        $value = substr($value, 1, -1);
                    }
                }
                $rowData[$expectedHeader] = $value;
            }
            
            // Validate required fields
            $requiredFields = ['NIK', 'NAME', 'ITEM CODE', 'DESCRIPTION', 'SIZE', 'QTY', 'GROUP', 'REQUEST DATE', 'REASON'];
            $emptyFields = [];
            
            foreach ($requiredFields as $field) {
                if (empty($rowData[$field]) && $rowData[$field] !== '0') {
                    $emptyFields[] = $field;
                }
            }
            
            if (!empty($emptyFields)) {
                $this->importErrors[] = [
                    'row' => $rowNumber,
                    'message' => 'Missing required data: ' . implode(', ', $emptyFields),
                    'data' => $rowData
                ];
                $this->importFailCount++;
                continue;
            }
            
            // ==================== MATCHING ITEM ====================
            $matchingItem = null;
            $itemIndex = null;
            
            $csvNik = (string)trim($rowData['NIK']);
            $csvItemCode = (string)trim($rowData['ITEM CODE']);
            $csvQty = (string)trim($rowData['QTY']);
            $csvRequestDate = (string)trim($rowData['REQUEST DATE']);
            
            // Cari item yang match dengan kombinasi NIK + ITEM CODE + QTY + REQUEST DATE
            // DAN belum digunakan (belum di-match)
            foreach ($itemsDetail as $index => $item) {
                // Skip jika sudah di-match
                if (in_array($index, $matchedIndices)) {
                    continue;
                }
                
                $itemNik = (string)trim($item['employee_nik']);
                $itemItemCode = (string)trim($item['item_code']);
                $itemQty = (string)trim($item['qty']);
                $itemRequestDate = (string)trim($item['request_date']);
                
                // Cek NIK + ITEM CODE + QTY
                if ($csvNik === $itemNik && $csvItemCode === $itemItemCode && $csvQty == $itemQty) {
                    // Cek REQUEST DATE
                    $csvDateParsed = $this->parseDate($csvRequestDate);
                    $itemDateParsed = $this->parseDate($itemRequestDate);
                    
                    $dateMatch = false;
                    if ($csvDateParsed && $itemDateParsed) {
                        if ($csvDateParsed->format('Y-m-d') === $itemDateParsed->format('Y-m-d')) {
                            $dateMatch = true;
                        }
                    } elseif (!$csvDateParsed && !$itemDateParsed) {
                        if ($csvRequestDate === $itemRequestDate) {
                            $dateMatch = true;
                        }
                    }
                    
                    if ($dateMatch) {
                        $matchingItem = $item;
                        $itemIndex = $index;
                        $matchedIndices[] = $index; // Tandai sudah digunakan
                        break;
                    }
                }
            }
            
            // Jika tidak ditemukan, coba match hanya NIK + ITEM CODE (fallback)
            if ($matchingItem === null) {
                foreach ($itemsDetail as $index => $item) {
                    if (in_array($index, $matchedIndices)) {
                        continue;
                    }
                    
                    $itemNik = (string)trim($item['employee_nik']);
                    $itemItemCode = (string)trim($item['item_code']);
                    
                    if ($csvNik === $itemNik && $csvItemCode === $itemItemCode) {
                        $matchingItem = $item;
                        $itemIndex = $index;
                        $matchedIndices[] = $index;
                        break;
                    }
                }
            }
            
            if ($matchingItem === null) {
                $this->importErrors[] = [
                    'row' => $rowNumber,
                    'message' => 'Data does not match existing request! NIK: ' . $rowData['NIK'] . ', Item Code: ' . $rowData['ITEM CODE'],
                    'data' => $rowData
                ];
                $this->importFailCount++;
                continue;
            }
            // ==================== END MATCHING ITEM ====================
            
            // ==================== VALIDASI ADMIN IMPORT ====================
            if ($this->importType === 'admin') {
                $adminFeedback = trim($rowData['ADMIN FEEDBACK'] ?? '');
                
                // 1. ADMIN FEEDBACK WAJIB DIISI
                if (empty($adminFeedback) || $adminFeedback === '-') {
                    $this->importErrors[] = [
                        'row' => $rowNumber,
                        'message' => 'ADMIN FEEDBACK is required!',
                        'data' => $rowData
                    ];
                    $this->importFailCount++;
                    continue;
                }
                
                // Cek apakah admin feedback sudah ada
                $dbAdminFeedback = $matchingItem['admin_feedback'] ?? '';
                if (!empty($dbAdminFeedback) && $dbAdminFeedback !== 'N/A (Manual Input)') {
                    // Jika sudah ada, cek apakah sama
                    if (strtolower(trim($adminFeedback)) !== strtolower(trim($dbAdminFeedback))) {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => 'Admin feedback mismatch! File: "' . $adminFeedback . '", Database: "' . $dbAdminFeedback . '"',
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                }
                
                // ==================== VALIDASI SALARY DEDUCTION ====================
                $salaryDeduction = null;
                $salaryAmount = null;
                $salaryError = null;

                $csvDeduction = strtolower(trim($rowData['SALARY DEDUCTION'] ?? ''));

                // Cek apakah item rejected
                $isRejected = isset($matchingItem['verification_status']) && $matchingItem['verification_status'] === 'rejected';

                // Jika item rejected, salary deduction otomatis N/A (tidak perlu diisi)
                if ($isRejected) {
                    $salaryDeduction = null;
                    $salaryAmount = null;
                } 
                // Jika ada data salary deduction di CSV
                elseif (!empty($csvDeduction)) {
                    if (!in_array($csvDeduction, ['yes', 'no'])) {
                        $salaryError = 'SALARY DEDUCTION must be "Yes" or "No"!';
                    } elseif ($csvDeduction === 'yes') {
                        $salaryDeduction = 'yes';
                        $uniform = MasterUniform::where('item_code', $matchingItem['item_code'])->first();
                        $salaryAmount = $uniform ? $uniform->price : 0;
                        
                        if ($salaryAmount <= 0) {
                            $salaryError = 'Price not found in Master Uniform!';
                        }
                    } else {
                        // Jika No
                        $salaryDeduction = 'no';
                        $salaryAmount = null;
                    }
                } 
                else {
                    $salaryError = 'SALARY DEDUCTION is required! Must be "Yes" or "No"';
                }

                if ($salaryError) {
                    $this->importErrors[] = [
                        'row' => $rowNumber,
                        'message' => 'Salary Deduction: ' . $salaryError,
                        'data' => $rowData
                    ];
                    $this->importFailCount++;
                    continue;
                }
                // ==================== END VALIDASI SALARY DEDUCTION ====================
                
                $this->importPreview[] = [
                    'row' => $rowNumber,
                    'item_index' => $itemIndex,
                    'nik' => $rowData['NIK'],
                    'name' => $rowData['NAME'],
                    'department' => $rowData['DEPARTMENT'] ?? '',
                    'item_code' => $rowData['ITEM CODE'],
                    'description' => $rowData['DESCRIPTION'],
                    'size' => $rowData['SIZE'],
                    'qty' => $rowData['QTY'],
                    'group' => $rowData['GROUP'],
                    'request_date' => $rowData['REQUEST DATE'],
                    'reason' => $rowData['REASON'],
                    'remarks' => $rowData['REMARKS'] ?: '-',
                    'feedback' => $adminFeedback,
                    'is_rejected' => $isRejected,
                    'salary_deduction' => $salaryDeduction,
                    'salary_amount' => $salaryAmount,
                ];
                $this->importSuccessCount++;
            }
            // ==================== END VALIDASI ADMIN IMPORT ====================
            
            // ==================== VALIDASI COSTING IMPORT ====================
            if ($this->importType === 'costing') {
                // 1. Cek apakah item manual
                $isManual = isset($matchingItem['is_manual']) && $matchingItem['is_manual'];
                
                // 2. Cek VERIFICATION STATUS dari database
                $dbVerificationStatus = $matchingItem['verification_status'] ?? '';
                
                // 3. Cek COSTING FEEDBACK dari file CSV
                $csvCostingFeedback = trim($rowData['COSTING FEEDBACK'] ?? '');
                $dbCostingFeedback = $matchingItem['costing_feedback'] ?? '';
                
                // 4. Jika verification status = rejected
                if ($dbVerificationStatus === 'rejected') {
                    // Jika status rejected dan costing feedback diisi → ERROR
                    if (!empty($csvCostingFeedback)) {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => "🚫 ITEM HAS BEEN REJECTED! Cannot add costing feedback. Please leave COSTING FEEDBACK empty. NIK: {$rowData['NIK']}, Item: {$rowData['ITEM CODE']}",
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    } else {
                        // Jika status rejected dan costing feedback kosong → OK (skip/ignore)
                        $this->importPreview[] = [
                            'row' => $rowNumber,
                            'item_index' => $itemIndex,
                            'nik' => $rowData['NIK'],
                            'name' => $rowData['NAME'],
                            'department' => $rowData['DEPARTMENT'] ?? '',
                            'item_code' => $rowData['ITEM CODE'],
                            'description' => $rowData['DESCRIPTION'],
                            'size' => $rowData['SIZE'],
                            'qty' => $rowData['QTY'],
                            'group' => $rowData['GROUP'],
                            'request_date' => $rowData['REQUEST DATE'],
                            'reason' => $rowData['REASON'],
                            'remarks' => $rowData['REMARKS'] ?: '-',
                            'feedback' => $csvCostingFeedback ?: '(REJECTED - No feedback added)',
                            'verification_status' => $matchingItem['verification_status'] ?? null,
                            'admin_feedback' => $matchingItem['admin_feedback'] ?? null,
                            'csv_verification_status' => $rowData['VERIFICATION STATUS'] ?? null,
                            'csv_admin_feedback' => $rowData['ADMIN FEEDBACK'] ?? null,
                            'is_rejected' => true,
                            'warning' => '⚠️ Item is REJECTED. No costing feedback will be added.'
                        ];
                        $this->importSuccessCount++;
                        continue;
                    }
                }
                
                // 5. Jika MANUAL INPUT - SKIP VERIFICATION
                if ($isManual) {
                    // Manual item: langsung lanjut ke costing feedback
                    // Cek apakah costing feedback diisi
                    if (empty($csvCostingFeedback) || $csvCostingFeedback === '-') {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => 'COSTING FEEDBACK cannot be empty for manual item! NIK: ' . $rowData['NIK'],
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                    
                    // Cek apakah COSTING FEEDBACK sudah ada
                    if (!empty($dbCostingFeedback)) {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => "⚠️ Costing feedback already exists! NIK: {$rowData['NIK']}, Existing: '{$dbCostingFeedback}'",
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                    
                    // Tambahkan ke preview untuk costing (manual)
                    $this->importPreview[] = [
                        'row' => $rowNumber,
                        'item_index' => $itemIndex,
                        'nik' => $rowData['NIK'],
                        'name' => $rowData['NAME'],
                        'department' => $rowData['DEPARTMENT'] ?? '',
                        'item_code' => $rowData['ITEM CODE'],
                        'description' => $rowData['DESCRIPTION'],
                        'size' => $rowData['SIZE'],
                        'qty' => $rowData['QTY'],
                        'group' => $rowData['GROUP'],
                        'request_date' => $rowData['REQUEST DATE'],
                        'reason' => $rowData['REASON'],
                        'remarks' => $rowData['REMARKS'] ?: '-',
                        'feedback' => $csvCostingFeedback ?? '',
                        'verification_status' => 'N/A',
                        'admin_feedback' => $matchingItem['admin_feedback'] ?? null,
                        'csv_verification_status' => $rowData['VERIFICATION STATUS'] ?? null,
                        'csv_admin_feedback' => $rowData['ADMIN FEEDBACK'] ?? null,
                        'is_rejected' => false,
                        'is_manual' => true,
                        'warning' => null,
                    ];
                    $this->importSuccessCount++;
                    continue;
                }
                
                // 6. Jika verification status kosong atau pending, TOLAK import (harus approved dulu)
                if (empty($dbVerificationStatus) || $dbVerificationStatus !== 'approved') {
                    $this->importErrors[] = [
                        'row' => $rowNumber,
                        'message' => "⚠️ ITEM NOT VERIFIED YET! Status: '{$dbVerificationStatus}'. Cannot add costing feedback. NIK: {$rowData['NIK']}, Item: {$rowData['ITEM CODE']}",
                        'data' => $rowData
                    ];
                    $this->importFailCount++;
                    continue;
                }
                
                // 7. Jika verification status = approved, lanjutkan validasi normal
                if ($dbVerificationStatus === 'approved') {
                    // Cek VERIFICATION STATUS dari file CSV harus match dengan database
                    $csvVerificationStatus = strtolower(trim($rowData['VERIFICATION STATUS'] ?? ''));
                    if ($csvVerificationStatus !== $dbVerificationStatus) {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => "❌ VERIFICATION STATUS mismatch! File: '{$csvVerificationStatus}', Database: '{$dbVerificationStatus}'. NIK: {$rowData['NIK']}",
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                    
                    // Cek ADMIN FEEDBACK dari file CSV harus match dengan database
                    $csvAdminFeedback = trim($rowData['ADMIN FEEDBACK'] ?? '');
                    $dbAdminFeedback = $matchingItem['admin_feedback'] ?? '';
                    
                    if (empty($csvAdminFeedback)) {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => 'ADMIN FEEDBACK is required for costing import! NIK: ' . $rowData['NIK'],
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                    
                    if (strtolower(trim($csvAdminFeedback)) !== strtolower(trim($dbAdminFeedback))) {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => "❌ ADMIN FEEDBACK mismatch! File: '{$csvAdminFeedback}', Database: '{$dbAdminFeedback}'. NIK: {$rowData['NIK']}",
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                    
                    // Cek apakah admin feedback sudah terisi di database
                    if (empty($dbAdminFeedback) || $dbAdminFeedback === 'N/A (Manual Input)') {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => 'Admin feedback must be filled before costing feedback! NIK: ' . $rowData['NIK'],
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                    
                    // Cek apakah COSTING FEEDBACK sudah ada
                    if (!empty($dbCostingFeedback)) {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => "⚠️ Costing feedback already exists! NIK: {$rowData['NIK']}, Existing: '{$dbCostingFeedback}'",
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                    
                    // Cek apakah COSTING FEEDBACK diisi
                    if (empty($csvCostingFeedback) || $csvCostingFeedback === '-') {
                        $this->importErrors[] = [
                            'row' => $rowNumber,
                            'message' => 'COSTING FEEDBACK cannot be empty for approved items! NIK: ' . $rowData['NIK'],
                            'data' => $rowData
                        ];
                        $this->importFailCount++;
                        continue;
                    }
                }
                
                // Tambahkan ke preview untuk costing (regular)
                $this->importPreview[] = [
                    'row' => $rowNumber,
                    'item_index' => $itemIndex,
                    'nik' => $rowData['NIK'],
                    'name' => $rowData['NAME'],
                    'department' => $rowData['DEPARTMENT'] ?? '',
                    'item_code' => $rowData['ITEM CODE'],
                    'description' => $rowData['DESCRIPTION'],
                    'size' => $rowData['SIZE'],
                    'qty' => $rowData['QTY'],
                    'group' => $rowData['GROUP'],
                    'request_date' => $rowData['REQUEST DATE'],
                    'reason' => $rowData['REASON'],
                    'remarks' => $rowData['REMARKS'] ?: '-',
                    'feedback' => $csvCostingFeedback ?? '',
                    'verification_status' => $matchingItem['verification_status'] ?? null,
                    'admin_feedback' => $matchingItem['admin_feedback'] ?? null,
                    'csv_verification_status' => $rowData['VERIFICATION STATUS'] ?? null,
                    'csv_admin_feedback' => $rowData['ADMIN FEEDBACK'] ?? null,
                    'is_rejected' => false,
                    'is_manual' => false,
                    'warning' => null,
                ];
                $this->importSuccessCount++;
            }
            // ==================== END VALIDASI COSTING IMPORT ====================
        }
        
        if ($this->importSuccessCount == 0 && $this->importFailCount > 0) {
            session()->flash('error', 'No valid data to import! Found ' . $this->importFailCount . ' error(s).');
        } elseif ($this->importSuccessCount > 0) {
            session()->flash('info', 'Preview loaded: ' . $this->importSuccessCount . ' record(s) ready to import, ' . $this->importFailCount . ' error(s).');
        }
    }

    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }
        
        $dateString = trim($dateString);
        
        $formats = [
            'Y-m-d', 'Y/m/d', 'd-m-Y', 'd/m/Y', 'Ymd', 'Y.m.d', 'd.m.Y', 'm/d/Y', 'm-d-Y'
        ];
        
        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $dateString);
            if ($date && $date->format($format) === $dateString) {
                return $date;
            }
        }
        
        try {
            return new \DateTime($dateString);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function saveImport()
    {
        if (empty($this->importPreview)) {
            session()->flash('error', 'No valid data to import!');
            return;
        }
        
        $items = $this->request->items;
        $updatedCount = 0;
        $skippedCount = 0;
        $currentDateTime = now()->toDateTimeString();
        $currentUser = auth()->user()->name;
        
        foreach ($this->importPreview as $preview) {
            // Skip rejected items (untuk costing)
            if (isset($preview['is_rejected']) && $preview['is_rejected']) {
                $skippedCount++;
                continue;
            }
            
            $itemIndex = $preview['item_index'];
            
            if ($this->importType === 'admin') {
                $items[$itemIndex]['admin_feedback'] = $preview['feedback'];
                $items[$itemIndex]['admin_feedback_datetime'] = $currentDateTime;
                $items[$itemIndex]['admin_feedback_by'] = $currentUser;
                
                // Update salary deduction (SELALU UPDATE jika ada data di preview)
                if (array_key_exists('salary_deduction', $preview)) {
                    $items[$itemIndex]['salary_deduction'] = $preview['salary_deduction'];
                    $items[$itemIndex]['deduction_amount'] = $preview['salary_amount'];
                    // Period akan auto generate saat signature
                    $items[$itemIndex]['payroll_period'] = null;
                    $items[$itemIndex]['salary_updated_by'] = $currentUser;
                    $items[$itemIndex]['salary_updated_at'] = $currentDateTime;
                }
            } else {
                // Update costing feedback
                $items[$itemIndex]['costing_feedback'] = $preview['feedback'];
                $items[$itemIndex]['costing_feedback_datetime'] = $currentDateTime;
                $items[$itemIndex]['costing_feedback_by'] = $currentUser;
            }
            
            $updatedCount++;
        }
        
        $this->request->update(['items' => $items]);
        $this->request = UniformRequest::with('creator')->find($this->requestId);
        
        // Kirim email ke emails user
        try {
            $recipients = ['sek.esd@siix-global.com']; // Default
            
            // Ambil dari user created_by
            if ($this->request->created_by) {
                $user = \App\Models\User::where('name', $this->request->created_by)->first();
                if ($user && !empty($user->emails)) {
                    if (is_string($user->emails)) {
                        $recipients = array_map('trim', explode(',', $user->emails));
                    } elseif (is_array($user->emails)) {
                        $recipients = $user->emails;
                    }
                }
            }
            
            // Kirim email sesuai tipe import
            if ($this->importType === 'admin') {
                Mail::to($recipients)->send(new AdminFeedbackImportedMail($this->request));
            } else {
                Mail::to($recipients)->send(new CostingFeedbackImportedMail($this->request));
            }
            
            // Log jika email kosong
            if ($recipients == ['sek.esd@siix-global.com']) {
                \Log::info('Email not found for user: ' . $this->request->created_by . ', using default email');
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to send import feedback email: ' . $e->getMessage());
        }
        
        $message = "Successfully imported {$updatedCount} {$this->importType} feedback(s)!";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} rejected item(s) were skipped.";
        }
        session()->flash('success', $message);
        
        $this->closeImportModal();
        $this->request = UniformRequest::with('creator')->find($this->requestId);
    }

    public function render()
    {
        $itemsDetail = $this->items_detail;
        
        // Ambil page dari property, bukan dari request
        $currentPage = $this->page;
        $perPage = $this->perPage;
        
        $paginatedItems = $itemsDetail->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedItems,
            $itemsDetail->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
        
        // Set path
        $pagination->setPath(request()->url());
        
        // Tambahkan listener untuk update page dari link
        $pagination->appends(['page' => $this->page]);
        
        return view('livewire.prod.uniform.uniform-request-show', [
            'itemsDetail' => $itemsDetail,
            'paginatedItems' => $pagination,
        ]);
    }

    public function gotoPage($page)
    {
        $this->page = $page;
    }

    public function updatedPerPage()
    {
        $this->page = 1;
    }
}