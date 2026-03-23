<?php

namespace App\Livewire\DCC;

use App\Mail\DCC\SubmissionDistributedMail;
use App\Mail\DCC\SubmissionStatusMail;
use App\Models\DCC\Department;
use App\Models\DCC\Submission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Mail;
use Livewire\Attributes\Url;

class SubmissionManagement extends Component
{
    use WithPagination, WithFileUploads;

    // Properties untuk form
    public $submission_id;
    public $category_document;
    public $description;
    public $revision;
    public $dept;
    public $emails = [];
    public $pic;
    public $due_date;
    public $documentation;
    public $remarks;
    public $status = 'Waiting Received';
    public $status_distribute = 'Waiting Distribute';
    public $received_by;
    public $reason;
    public $reason_to_delete;
    public $distributingSubmissionId;

    // For file upload
    public $documentation_file;
    public $existing_documentation;

    // For filters
    #[Url(as: 'search', history: true)]
    public $search = '';

    #[Url(as: 'status', history: true)]
    public $filterStatus = '';

    #[Url(as: 'dept', history: true)]
    public $filterDept = '';

    #[Url(as: 'category', history: true)]
    public $filterCategory = '';

    #[Url(as: 'year', history: true)]
    public $filterYear = '';

    #[Url(as: 'month', history: true)]
    public $filterMonth = '';

    #[Url(as: 'date_from', history: true)]
    public $filterDateFrom = '';

    #[Url(as: 'date_until', history: true)]
    public $filterDateUntil = '';

    #[Url(as: 'distributed', history: true)]
    public $filterDistributed = '';

    public $showFilters = false;

    // For bulk actions
    public $selectedSubmissions = [];
    public $selectAll = false;
    public $perPage = 10;

    // Page management
    public $currentPage = 'index'; // index, create, edit, show, receive, delete
    public $submissionToDelete = null;
    public $receivingSubmission = null;
    public $distributingSubmission = null;
    public $receiveStatus = '';
    public $receiveReason = '';

    // Loading state
    public $isLoading = false;

    // Category options
    public $categoryOptions = [
        'Quality Manual' => 'Quality Manual',
        'QEP/QES/QEC' => 'QEP/QES/QEC',
        'Work Instruction' => 'Work Instruction',
        'FMEA/CP/SH/SQ' => 'FMEA/CP/SH/SQ',
        'Quality Reminder' => 'Quality Reminder',
        'BOM' => 'BOM',
        'CLL' => 'CLL',
        'ECR' => 'ECR',
        'External Document' => 'External Document',
        'SJ' => 'SJ',
        'SV' => 'SV',
        'Component Library' => 'Component Library',
    ];

    protected function rules()
    {
        return [
            'category_document' => 'required',
            'description' => 'required|min:3|max:255',
            'revision' => 'required',
            'dept' => 'required|exists:tb_dcc_departments,dept_name',
            'emails' => 'required|array|min:1',
            'pic' => 'required',
            'due_date' => 'required|date|after_or_equal:today',
            'remarks' => 'nullable',
            'documentation_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,jpg,jpeg,png|max:10240',
        ];
    }

    protected $messages = [
        'category_document.required' => 'Category document is required.',
        'description.required' => 'Description is required.',
        'revision.required' => 'Revision is required.',
        'dept.required' => 'Department is required.',
        'dept.exists' => 'Selected department is invalid.',
        'emails.required' => 'At least one email is required.',
        'emails.min' => 'At least one email must be selected.',
        'pic.required' => 'PIC is required.',
        'due_date.required' => 'Due date is required.',
        'due_date.after_or_equal' => 'Due date must be today or future date.',
        'documentation_file.max' => 'File size must not exceed 10MB.',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'submission_id', 'category_document', 'description', 'revision', 'dept',
            'emails', 'pic', 'due_date', 'remarks', 'documentation_file',
            'existing_documentation', 'status', 'status_distribute', 'reason',
            'receiveStatus', 'receiveReason', 'reason_to_delete'
        ]);
        $this->resetValidation();
    }

    /**
     * Parse emails from various formats (string, JSON, array)
     */
    private function parseEmails($emails)
    {
        if (is_array($emails)) {
            return $emails;
        }
        
        if (is_string($emails)) {
            // Try to decode JSON first
            $decoded = json_decode($emails, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            
            // Otherwise, split by comma
            return array_map('trim', explode(',', $emails));
        }
        
        return [];
    }

    /**
     * Format emails for storage (as JSON)
     */
    private function formatEmailsForStorage($emails)
    {
        if (is_array($emails)) {
            return json_encode($emails);
        }
        return $emails;
    }

    public function updatedDept($value)
    {
        // Reset emails when department changes
        $this->emails = [];
        
        if ($value) {
            $department = Department::where('dept_name', $value)->first();
            if ($department && $department->emails) {
                // Handle both string and array
                $this->emails = $this->parseEmails($department->emails);
            }
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Get only the submissions on the current page
            $currentPageSubmissions = $this->getFilteredQuery()
                ->latest()
                ->paginate(10) // Must match the pagination count in render()
                ->pluck('id')
                ->toArray();
            
            $this->selectedSubmissions = $currentPageSubmissions;
        } else {
            $this->selectedSubmissions = [];
        }
    }

    protected function getFilteredQuery()
    {
        $query = Submission::with(['department', 'creator']);
    
        $user = auth()->user();
    
        if ($user->can('view submissions one user')) {
            $query->where('created_by', $user->id);
        }
    
        $query
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('description', 'like', '%' . $this->search . '%')
                        ->orWhere('revision', 'like', '%' . $this->search . '%')
                        ->orWhere('remarks', 'like', '%' . $this->search . '%')
                        ->orWhere('pic', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterDistributed, fn($q) => $q->where('status_distribute', $this->filterDistributed))
            ->when($this->filterDept, fn($q) => $q->where('dept', $this->filterDept))
            ->when($this->filterCategory, fn($q) => $q->where('category_document', $this->filterCategory))
            ->when($this->filterYear, fn($q) => $q->whereYear('created_at', $this->filterYear))
            ->when($this->filterMonth, fn($q) => $q->whereMonth('created_at', $this->filterMonth))
            ->when($this->filterDateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->filterDateFrom))
            ->when($this->filterDateUntil, fn($q) => $q->whereDate('created_at', '<=', $this->filterDateUntil));
    
        return $query;
    }

    public function toggleEmail($email)
    {
        if (in_array($email, $this->emails)) {
            // Remove email
            $this->emails = array_values(array_filter($this->emails, function($e) use ($email) {
                return $e !== $email;
            }));
        } else {
            // Add email
            $this->emails[] = $email;
        }
    }

    public function selectAllEmails()
    {
        if ($this->dept) {
            $department = Department::where('dept_name', $this->dept)->first();
            if ($department && $department->emails) {
                $this->emails = $this->parseEmails($department->emails);
            }
        }
    }

    public function clearAllEmails()
    {
        $this->emails = [];
    }

    public function goToCreate()
    {
        $this->resetForm();
        $this->currentPage = 'create';
    }

    public function goToEdit($id)
    {
        if (!auth()->user()->can('edit submissions')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $submission = Submission::find($id);

        if (!$submission) {
            $this->dispatch('notify', message: 'Submission not found!', type: 'error');
            return;
        }

        $this->submission_id = $submission->id;
        $this->category_document = $submission->category_document;
        $this->description = $submission->description;
        $this->revision = $submission->revision;
        $this->dept = $submission->dept;
        
        // Handle emails (string or array)
        $this->emails = $this->parseEmails($submission->emails);
        
        $this->pic = $submission->pic;
        $this->due_date = $submission->due_date?->format('Y-m-d');
        $this->existing_documentation = $submission->documentation;
        $this->remarks = $submission->remarks;
        $this->status = $submission->status;
        $this->status_distribute = $submission->status_distribute;
        $this->reason = $submission->reason;

        $this->currentPage = 'edit';
    }

    public function goToShow($id)
    {
        $submission = Submission::find($id);
        
        if (!$submission) {
            $this->dispatch('notify', message: 'Submission not found!', type: 'error');
            return;
        }

        $this->receivingSubmission = $submission;
        $this->currentPage = 'show';
    }

    public function goToReceive($id)
    {
        if (!auth()->user()->can('receive submissions')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $submission = Submission::find($id);
        
        if (!$submission) {
            $this->dispatch('notify', message: 'Submission not found!', type: 'error');
            return;
        }

        if (!$submission->canReceive()) {
            $this->dispatch('notify', message: 'Cannot receive this submission!', type: 'error');
            return;
        }

        $this->receivingSubmission = $submission;
        $this->receiveStatus = '';
        $this->receiveReason = '';
        $this->currentPage = 'receive';
    }

    public function goToDistribute($id)
    {
        $submission = Submission::find($id);
    
        if (!$submission) {
            $this->dispatch('notify', message: 'Submission not found!', type: 'error');
            return;
        }
    
        if (!$submission->canMarkDistributed()) {
            $this->dispatch('notify', message: 'Cannot mark this submission as distributed!', type: 'error');
            return;
        }
    
        $this->distributingSubmission = $submission; // 🔥 INI YANG KURANG
        $this->distributingSubmissionId = $submission->id;
    
        $this->currentPage = 'distribute';
    }

    public function goToDelete($id)
    {
        if (!auth()->user()->can('delete submissions')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $submission = Submission::find($id);

        if (!$submission) {
            $this->dispatch('notify', message: 'Submission not found!', type: 'error');
            return;
        }

        if (!$submission->canDelete()) {
            $this->dispatch('notify', message: 'Cannot delete submission after 24 hours!', type: 'error');
            return;
        }

        $this->submissionToDelete = $submission;
        $this->reason_to_delete = '';
        $this->currentPage = 'delete';
    }

    public function backToIndex()
    {
        $this->resetForm();
        $this->currentPage = 'index';
    }

    public function save()
    {
        $this->isLoading = true;
        
        try {
            if ($this->submission_id) {
                if (!auth()->user()->can('edit submissions')) {
                    $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                    return;
                }
            } else {
                if (!auth()->user()->can('create submissions')) {
                    $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                    return;
                }
            }

            $this->validate();

            // Handle file upload
            $documentationPath = $this->existing_documentation;
            if ($this->documentation_file) {
                if ($this->existing_documentation) {
                    Storage::disk('public')->delete($this->existing_documentation);
                }

                $documentationPath = $this->documentation_file->store('submissions', 'public');
            }

            $data = [
                'category_document' => $this->category_document,
                'description' => strtoupper($this->description),
                'revision' => $this->revision,
                'dept' => $this->dept,
                'emails' => $this->formatEmailsForStorage($this->emails),
                'pic' => strtoupper($this->pic),
                'due_date' => Carbon::parse($this->due_date),
                'documentation' => $documentationPath,
                'remarks' => $this->remarks,
                'status' => $this->status,
                'status_distribute' => $this->status_distribute,
            ];

            if ($this->submission_id) {
                $submission = Submission::find($this->submission_id);
                if (!$submission) {
                    throw new \Exception('Submission not found!');
                }

                $submission->update($data);
                $message = 'Submission updated successfully!';
            } else {
                $data['created_by'] = auth()->id();
                Submission::create($data);
                $message = 'Submission created successfully!';
            }

            $this->dispatch('notify', message: $message, type: 'success');
            $this->backToIndex();
            
        } catch (\Exception $e) {
            Log::error('Save submission error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isLoading = false;
        }
    }

    public function processReceive()
    {
        $this->isLoading = true;
        
        try {
            $this->validate([
                'receiveStatus' => 'required|in:Received,Rejected',
                'receiveReason' => 'required_if:receiveStatus,Rejected',
            ]);
    
            $submission = Submission::find($this->receivingSubmission->id);
    
            if (!$submission) {
                throw new \Exception('Submission not found!');
            }
    
            $user = auth()->user();
    
            // Update status
            $submission->status = $this->receiveStatus;
            $submission->received_by = $user->name;
            $submission->received_at = now();
    
            if ($this->receiveStatus === 'Rejected') {
                $submission->reason = $this->receiveReason;
                $submission->status_distribute = null; // reset status_distribute jika Rejected
            } else {
                $submission->reason = null;
                $submission->status_distribute = 'Waiting Distribute';
            }
    
            $submission->save();
    
            // KIRIM EMAIL KE SEMUA EMAILS TERKAIT
            if ($submission->emails) {
                // Parse emails dari JSON/string ke array
                $emails = $this->parseEmails($submission->emails);
                
                if (is_array($emails) && count($emails) > 0) {
                    foreach ($emails as $email) {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            Mail::to($email)->send(new SubmissionStatusMail($submission));
                        }
                    }
                    
                    // Log untuk debugging
                    \Log::info('Status email sent', [
                        'submission_id' => $submission->id,
                        'status' => $this->receiveStatus,
                        'emails' => $emails
                    ]);
                }
            }
    
            $this->dispatch('notify', message: 'Submission status updated successfully!', type: 'success');
            $this->backToIndex();
            
        } catch (\Exception $e) {
            \Log::error('Process receive error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isLoading = false;
        }
    }

    public function processDistribute()
    {
        $this->isLoading = true;
    
        try {
            $submission = Submission::find($this->distributingSubmissionId);
    
            if (!$submission) {
                throw new \Exception('Submission not found!');
            }
    
            $user = auth()->user();
    
            // Update status distribute
            $submission->status_distribute = 'Distributed';
            $submission->distributed_at = now();
            $submission->distributed_by = $user->name;
            $submission->save();
    
            // KIRIM EMAIL KE SEMUA EMAILS TERKAIT
            if ($submission->emails) {
                // Parse emails dari JSON/string ke array
                $emails = $this->parseEmails($submission->emails);
                
                if (is_array($emails) && count($emails) > 0) {
                    foreach ($emails as $email) {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            Mail::to($email)->send(new SubmissionDistributedMail($submission));
                        }
                    }
                    
                    // Log untuk debugging
                    \Log::info('Distribution email sent', [
                        'submission_id' => $submission->id,
                        'distributed_by' => $user->name,
                        'emails' => $emails
                    ]);
                }
            }
    
            $this->dispatch('notify', message: 'Submission marked as distributed!', type: 'success');
            $this->backToIndex();
    
        } catch (\Exception $e) {
            \Log::error('Process distribute error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isLoading = false;
        }
    }

    public function processDelete()
    {
        $this->isLoading = true;
        
        try {
            if (!auth()->user()->can('delete submissions')) {
                throw new \Exception('You do not have permission!');
            }

            $this->validate([
                'reason_to_delete' => 'required',
            ]);

            $submission = Submission::find($this->submissionToDelete->id);

            if (!$submission) {
                throw new \Exception('Submission not found!');
            }

            // Hapus file jika ada
            if ($submission->documentation) {
                Storage::disk('public')->delete($submission->documentation);
            }

            // Simpan reason sebelum delete
            $submission->reason_to_delete = $this->reason_to_delete;
            $submission->deleted_by = auth()->user()->name;
            $submission->deleted_at = now();
            $submission->save();
            
            // Soft delete
            $submission->delete();

            $this->dispatch('notify', message: 'Submission deleted successfully!', type: 'success');
            $this->backToIndex();
            
        } catch (\Exception $e) {
            Log::error('Delete submission error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isLoading = false;
        }
    }

    public function bulkReceive()
    {
        if (!auth()->user()->can('receive submissions')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->selectedSubmissions)) {
            $this->dispatch('notify', message: 'No submissions selected!', type: 'error');
            return;
        }

        $this->isLoading = true;
        
        try {
            $count = 0;
            foreach ($this->selectedSubmissions as $id) {
                $submission = Submission::find($id);
                if ($submission && $submission->canReceive()) {
                    $submission->received_by = auth()->user()->name;
                    $submission->received_at = now();
                    $submission->status = 'Received';
                    $submission->status_distribute = 'Waiting Distribute';
                    $submission->save();
                    $count++;
                }
            }

            $this->selectedSubmissions = [];
            $this->selectAll = false;

            $this->dispatch('notify', message: "{$count} submissions marked as received!", type: 'success');
            
        } catch (\Exception $e) {
            Log::error('Bulk receive error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isLoading = false;
        }
    }

    public function bulkMarkDistributed()
    {
        if (empty($this->selectedSubmissions)) {
            $this->dispatch('notify', message: 'No submissions selected!', type: 'error');
            return;
        }

        $this->isLoading = true;
        
        try {
            $count = 0;
            foreach ($this->selectedSubmissions as $id) {
                $submission = Submission::find($id);
                if ($submission && $submission->canMarkDistributed()) {
                    $submission->status_distribute = 'Distributed';
                    $submission->distributed_at = now();
                    $submission->distributed_by = auth()->user()->name;
                    $submission->save();
                    $count++;
                }
            }

            $this->selectedSubmissions = [];
            $this->selectAll = false;

            $this->dispatch('notify', message: "{$count} submissions marked as distributed!", type: 'success');
            
        } catch (\Exception $e) {
            Log::error('Bulk distribute error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isLoading = false;
        }
    }

    public function downloadDocumentation($id)
    {
        $submission = Submission::find($id);

        if (!$submission || !$submission->documentation) {
            $this->dispatch('notify', message: 'File not found!', type: 'error');
            return;
        }

        return Storage::disk('public')->download($submission->documentation);
    }

    public function clearFilters()
    {
        $this->filterStatus = '';
        $this->filterDept = '';
        $this->filterCategory = '';
        $this->filterYear = '';
        $this->filterMonth = '';
        $this->filterDateFrom = '';
        $this->filterDateUntil = '';
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        if (
            !auth()->user()->can('view submissions') &&
            !auth()->user()->can('view submissions one user')
        ) {
            abort(403, 'Unauthorized access.');
        }
    
        $submissions = $this->getFilteredQuery()
            ->latest()
            ->paginate($this->perPage);
    
        $allDepartments = Department::with('creator')
            ->latest('id')
            ->get();
    
        $users = User::orderBy('name')->get();
    
        $years = Submission::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();
    
        $months = [
            '01' => 'January','02' => 'February','03' => 'March',
            '04' => 'April','05' => 'May','06' => 'June',
            '07' => 'July','08' => 'August','09' => 'September',
            '10' => 'October','11' => 'November','12' => 'December',
        ];
    
        $categories = Submission::distinct()
            ->whereNotNull('category_document')
            ->pluck('category_document')
            ->toArray();
    
        return view('livewire.dcc.submission-management', [
            'submissions' => $submissions,
            'allDepartments' => $allDepartments,
            'users' => $users,
            'years' => $years,
            'months' => $months,
            'categories' => $categories,
    
            // 🔥 TAMBAHKAN INI
            'distributingSubmission' => $this->distributingSubmission,
        ]);
    }
}