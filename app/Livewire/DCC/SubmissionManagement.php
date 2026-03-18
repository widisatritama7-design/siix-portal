<?php

namespace App\Livewire\DCC;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\DCC\Submission;
use App\Models\DCC\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

    // For file upload
    public $documentation_file;
    public $existing_documentation;

    // For filters
    public $search = '';
    public $filterStatus = '';
    public $filterDept = '';
    public $filterCategory = '';
    public $filterYear = '';
    public $filterMonth = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $showFilters = false;

    // For bulk actions
    public $selectedSubmissions = [];
    public $selectAll = false;

    // For modals
    public $modalTitle = 'Add New Submission';
    public $submissionToDelete = null;
    public $receivingSubmission = null;
    public $distributingSubmission = null;
    public $receiveStatus = '';
    public $receiveReason = '';

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

    public function resetForm()
    {
        $this->reset([
            'submission_id', 'category_document', 'description', 'revision', 'dept',
            'emails', 'pic', 'due_date', 'remarks', 'documentation_file',
            'existing_documentation', 'status', 'status_distribute', 'reason'
        ]);
        $this->modalTitle = 'Add New Submission';
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
            $this->selectedSubmissions = $this->getFilteredQuery()->pluck('id')->toArray();
        } else {
            $this->selectedSubmissions = [];
        }
    }

    protected function getFilteredQuery()
    {
        $query = Submission::with(['department', 'creator'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('description', 'like', '%' . $this->search . '%')
                        ->orWhere('revision', 'like', '%' . $this->search . '%')
                        ->orWhere('remarks', 'like', '%' . $this->search . '%')
                        ->orWhere('pic', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
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

    public function save()
    {
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

            // Compress image if it's an image file
            if (in_array($this->documentation_file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                $this->compressImage($documentationPath);
            }
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
                $this->dispatch('notify', message: 'Submission not found!', type: 'error');
                return;
            }

            $submission->update($data);
            $message = 'Submission updated successfully!';
        } else {
            Submission::create($data);
            $message = 'Submission created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'submission-form-modal');
    }

    private function compressImage($path)
    {
        $fullPath = Storage::disk('public')->path($path);
        
        // Get image info
        $imageInfo = getimagesize($fullPath);
        $mimeType = $imageInfo['mime'];
        
        // Load image based on mime type
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($fullPath);
                imagejpeg($image, $fullPath, 75); // 75% quality
                break;
            case 'image/png':
                $image = imagecreatefrompng($fullPath);
                imagepng($image, $fullPath, 6); // Compression level 6 (0-9)
                break;
            case 'image/gif':
                $image = imagecreatefromgif($fullPath);
                imagegif($image, $fullPath);
                break;
        }
        
        if (isset($image)) {
            imagedestroy($image);
        }
    }

    public function edit($id)
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

        $this->modalTitle = 'Edit Submission';
    }

    public function openReceiveModal($id)
    {
        if (!auth()->user()->can('receive submissions')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $submission = Submission::find($id);
        if ($submission && $submission->canReceive()) {
            $this->receivingSubmission = $submission;
            $this->receiveStatus = '';
            $this->receiveReason = '';
            $this->dispatch('open-modal', 'receive-modal');
        }
    }

    public function processReceive()
    {
        $this->validate([
            'receiveStatus' => 'required|in:Received,Rejected',
            'receiveReason' => 'required_if:receiveStatus,Rejected',
        ]);

        $submission = Submission::find($this->receivingSubmission->id);

        if (!$submission) {
            $this->dispatch('notify', message: 'Submission not found!', type: 'error');
            $this->dispatch('close-modal', 'receive-modal');
            return;
        }

        $submission->status = $this->receiveStatus;
        $submission->received_by = auth()->user()->name;

        if ($this->receiveStatus === 'Rejected') {
            $submission->reason = $this->receiveReason;
            $submission->status_distribute = null;
        } else {
            $submission->reason = null;
        }

        $submission->save();

        // Send emails
        if ($submission->emails && is_array($submission->emails)) {
            foreach ($submission->emails as $email) {
                try {
                    // Mail::to($email)->send(new SubmissionStatusMail($submission));
                } catch (\Exception $e) {
                    // Log error but continue
                }
            }
        }

        $this->dispatch('notify', message: 'Submission status updated successfully!');
        $this->dispatch('close-modal', 'receive-modal');
        $this->reset(['receiveStatus', 'receiveReason', 'receivingSubmission']);
    }

    public function openDistributeModal($id)
    {
        $submission = Submission::find($id);
        if ($submission && $submission->canMarkDistributed()) {
            $this->distributingSubmission = $submission;
            $this->dispatch('open-modal', 'distribute-modal');
        }
    }

    public function processDistribute()
    {
        $submission = Submission::find($this->distributingSubmission->id);

        if (!$submission) {
            $this->dispatch('notify', message: 'Submission not found!', type: 'error');
            $this->dispatch('close-modal', 'distribute-modal');
            return;
        }

        $submission->status_distribute = 'Distributed';
        $submission->save();

        $this->dispatch('notify', message: 'Submission marked as distributed!');
        $this->dispatch('close-modal', 'distribute-modal');
        $this->reset(['distributingSubmission']);
    }

    public function confirmDelete($id)
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
        $this->dispatch('open-modal', 'delete-reason-modal');
    }

    public function deleteWithReason()
    {
        if (!auth()->user()->can('delete submissions')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $this->validate([
            'reason_to_delete' => 'required',
        ]);

        $submission = Submission::find($this->submissionToDelete->id);

        if (!$submission) {
            $this->dispatch('notify', message: 'Submission not found!', type: 'error');
            $this->dispatch('close-modal', 'delete-reason-modal');
            return;
        }

        if ($submission->documentation) {
            Storage::disk('public')->delete($submission->documentation);
        }

        $submission->reason_to_delete = $this->reason_to_delete;
        $submission->save();
        $submission->delete();

        $this->reset(['reason_to_delete', 'submissionToDelete']);
        $this->dispatch('notify', message: 'Submission deleted successfully!');
        $this->dispatch('close-modal', 'delete-reason-modal');
    }

    public function cancelDelete()
    {
        $this->submissionToDelete = null;
        $this->reason_to_delete = '';
        $this->dispatch('close-modal', 'delete-reason-modal');
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

        $count = 0;
        foreach ($this->selectedSubmissions as $id) {
            $submission = Submission::find($id);
            if ($submission && $submission->canReceive()) {
                $submission->received_by = auth()->user()->name;
                $submission->status = 'Received';
                $submission->save();
                $count++;
            }
        }

        $this->selectedSubmissions = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} submissions marked as received!");
    }

    public function bulkMarkDistributed()
    {
        if (empty($this->selectedSubmissions)) {
            $this->dispatch('notify', message: 'No submissions selected!', type: 'error');
            return;
        }

        $count = 0;
        foreach ($this->selectedSubmissions as $id) {
            $submission = Submission::find($id);
            if ($submission && $submission->canMarkDistributed()) {
                $submission->status_distribute = 'Distributed';
                $submission->save();
                $count++;
            }
        }

        $this->selectedSubmissions = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} submissions marked as distributed!");
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
        if (!auth()->user()->can('view submissions')) {
            abort(403, 'Unauthorized access.');
        }

        $submissions = $this->getFilteredQuery()
            ->latest()
            ->paginate(10);

        $departments = Department::with('creator')
            ->when($this->search, function ($query) {
                $query->where('dept_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc') // UBAH INI - berdasarkan ID terbaru
            ->paginate(10);
        $users = User::orderBy('name')->get();

        // Get filter options
        $years = Submission::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        $months = [
            '01' => 'January', '02' => 'February', '03' => 'March',
            '04' => 'April', '05' => 'May', '06' => 'June',
            '07' => 'July', '08' => 'August', '09' => 'September',
            '10' => 'October', '11' => 'November', '12' => 'December',
        ];

        $categories = Submission::distinct()
            ->whereNotNull('category_document')
            ->pluck('category_document')
            ->toArray();

        return view('livewire.dcc.submission-management', [
            'submissions' => $submissions,
            'departments' => $departments,
            'users' => $users,
            'years' => $years,
            'months' => $months,
            'categories' => $categories,
        ]);
    }
}