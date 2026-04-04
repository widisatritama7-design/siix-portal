<?php

namespace App\Livewire\ESD\PQ;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ESD\PQ\ProductQualification;
use App\Models\ESD\PQ\ProductQualificationDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductQualificationShow extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $qualification;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterStatus;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $qualification_id;
    public $supplier_name;
    public $description;
    public $status;
    public $modalTitle = 'Add New Qualification Detail';
    public $detailToDelete = null;
    
    // For file upload
    public $data_sheet_file;
    public $test_report_file;
    public $existing_data_sheet;
    public $existing_test_report;
    public $remove_data_sheet = false;
    public $remove_test_report = false;
    
    // Temporary file paths
    public $temp_data_sheet_path;
    public $temp_test_report_path;
    
    // Status options
    public $statusOptions = [
        'Pending' => 'Pending',
        'Accepted' => 'Accepted',
        'Rejected' => 'Rejected',
    ];

    protected function rules()
    {
        $rules = [
            'qualification_id' => 'required|exists:tb_esd_product_qualifications,id',
            'supplier_name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:Pending,Accepted,Rejected',
        ];
        
        // Only validate if files are present
        if ($this->data_sheet_file) {
            $rules['data_sheet_file'] = 'file|mimes:pdf,doc,docx,xlsx,xls|max:10240';
        }
        if ($this->test_report_file) {
            $rules['test_report_file'] = 'file|mimes:pdf,doc,docx,xlsx,xls|max:10240';
        }
        
        return $rules;
    }
    
    protected function messages()
    {
        return [
            'qualification_id.required' => 'Product qualification is required.',
            'supplier_name.required' => 'Supplier name is required.',
            'description.required' => 'Description is required.',
            'status.required' => 'Status is required.',
            'data_sheet_file.mimes' => 'Data sheet must be a PDF, DOC, DOCX, XLSX, or XLS file.',
            'data_sheet_file.max' => 'Data sheet cannot exceed 10MB.',
            'test_report_file.mimes' => 'Test report must be a PDF, DOC, DOCX, XLSX, or XLS file.',
            'test_report_file.max' => 'Test report cannot exceed 10MB.',
        ];
    }

    public function mount($id)
    {
        $this->qualification = ProductQualification::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view pq')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->status = 'Pending';
    }

    public function getStatusClass($status)
    {
        return match($status) {
            'Accepted' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'Rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
            'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
        };
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'supplier_name', 'description', 'status', 
            'data_sheet_file', 'test_report_file', 'existing_data_sheet', 
            'existing_test_report', 'remove_data_sheet', 'remove_test_report',
            'temp_data_sheet_path', 'temp_test_report_path'
        ]);
        $this->status = 'Pending';
        $this->modalTitle = 'Add New Qualification Detail';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['filterDateFrom', 'filterDateUntil', 'filterStatus', 'search']);
        $this->resetPage();
    }

    public function updatedDataSheetFile()
    {
        $this->validate([
            'data_sheet_file' => 'file|mimes:pdf,doc,docx,xlsx,xls|max:10240',
        ]);
    }

    public function updatedTestReportFile()
    {
        $this->validate([
            'test_report_file' => 'file|mimes:pdf,doc,docx,xlsx,xls|max:10240',
        ]);
    }

    public function save()
    {
        if ($this->detail_id) {
            if (!auth()->user()->can('edit pq')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create pq')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }
    
        $this->qualification_id = $this->qualification->id;
    
        // Validate
        $this->validate();
    
        $data = [
            'product_qualification_id' => $this->qualification_id,
            'supplier_name' => $this->supplier_name,
            'description' => $this->description,
            'status' => $this->status,
        ];
    
        // Handle Data Sheet
        if ($this->remove_data_sheet) {
            // Delete existing file
            if ($this->existing_data_sheet) {
                $oldPath = str_replace('/storage', 'public', $this->existing_data_sheet);
                Storage::disk('public')->delete($oldPath);
            }
            $data['data_sheet'] = null;
            $this->existing_data_sheet = null;
        } elseif ($this->data_sheet_file) {
            // Delete old file if exists
            if ($this->existing_data_sheet) {
                $oldPath = str_replace('/storage', 'public', $this->existing_data_sheet);
                Storage::disk('public')->delete($oldPath);
            }
            
            // Upload new file
            $originalName = pathinfo($this->data_sheet_file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $this->data_sheet_file->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName);
            $fileName = time() . '_' . $safeName . '.' . $extension;
            $filePath = $this->data_sheet_file->storeAs('pq/data_sheets', $fileName, 'public');
            $data['data_sheet'] = Storage::url($filePath);
            $this->existing_data_sheet = $data['data_sheet'];
        } elseif ($this->detail_id && $this->existing_data_sheet) {
            // Keep existing file
            $data['data_sheet'] = $this->existing_data_sheet;
        }
    
        // Handle Test Report
        if ($this->remove_test_report) {
            // Delete existing file
            if ($this->existing_test_report) {
                $oldPath = str_replace('/storage', 'public', $this->existing_test_report);
                Storage::disk('public')->delete($oldPath);
            }
            $data['test_report'] = null;
            $this->existing_test_report = null;
        } elseif ($this->test_report_file) {
            // Delete old file if exists
            if ($this->existing_test_report) {
                $oldPath = str_replace('/storage', 'public', $this->existing_test_report);
                Storage::disk('public')->delete($oldPath);
            }
            
            // Upload new file
            $originalName = pathinfo($this->test_report_file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $this->test_report_file->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName);
            $fileName = time() . '_' . $safeName . '.' . $extension;
            $filePath = $this->test_report_file->storeAs('pq/test_reports', $fileName, 'public');
            $data['test_report'] = Storage::url($filePath);
            $this->existing_test_report = $data['test_report'];
        } elseif ($this->detail_id && $this->existing_test_report) {
            // Keep existing file
            $data['test_report'] = $this->existing_test_report;
        }
    
        if ($this->detail_id) {
            $detail = ProductQualificationDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Qualification detail updated successfully!';
        } else {
            ProductQualificationDetail::create($data);
            $message = 'Qualification detail created successfully!';
        }
    
        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit pq')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }
    
        $detail = ProductQualificationDetail::with('productQualification')->find($id);
    
        if (!$detail) {
            $this->dispatch('notify', message: 'Record not found!', type: 'error');
            return;
        }
    
        $this->detail_id = $detail->id;
        $this->qualification_id = $detail->product_qualification_id;
        $this->supplier_name = $detail->supplier_name;
        $this->description = $detail->description;
        $this->existing_data_sheet = $detail->data_sheet;
        $this->existing_test_report = $detail->test_report;
        $this->status = $detail->status;
        $this->remove_data_sheet = false;
        $this->remove_test_report = false;
        $this->modalTitle = 'Edit Qualification Detail';
        
        // Reset file uploads
        $this->data_sheet_file = null;
        $this->test_report_file = null;
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete pq')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ProductQualificationDetail::with('productQualification')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Record not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete pq')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ProductQualificationDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        // Delete files from storage
        if ($detail->data_sheet) {
            $path = str_replace('/storage', 'public', $detail->data_sheet);
            Storage::disk('public')->delete($path);
        }
        if ($detail->test_report) {
            $path = str_replace('/storage', 'public', $detail->test_report);
            Storage::disk('public')->delete($path);
        }

        $supplierName = $detail->supplier_name ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Qualification for '{$supplierName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = ProductQualificationDetail::with(['productQualification', 'creator'])
            ->where('product_qualification_id', $this->qualification->id)
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('created_at', '<=', $this->filterDateUntil);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->search, function ($query) {
                $query->where('supplier_name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.esd.pq.product-qualification-show', [
            'details' => $details,
        ]);
    }
}