<?php

namespace App\Livewire\Ticket;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\CategoryTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\Ticket\TicketCreated;
use App\Mail\Ticket\TicketCreatedForUser;
use Carbon\Carbon;
use Livewire\Attributes\Url;

class TicketManager extends Component
{
    use WithFileUploads, WithPagination;

// Wizard steps
    public $currentStep = 1;
    public $totalSteps = 3;
    
    // Ticket Information
    public $ticket_number;
    public $title;
    public $registration_no;
    public $email_user;
    
    // Details & Upload
    public $description;
    public $files = [];
    public $tempFiles = [];
    
    // Categorization & Priority
    public $priority;
    public $assigned_role = 'ADMINESD';
    public $category_id;
    
    // Search & Filters - Add URL attributes
    #[Url(as: 'q', history: true)]
    public $search = '';
    
    #[Url(history: true)]
    public $statusFilter = '';
    
    #[Url(history: true)]
    public $dateFrom = '';
    
    #[Url(history: true)]
    public $dateTo = '';
    
    #[Url(as: 'pic_approval', history: true)]
    public $picApprovalFilter = '';
    
    #[Url(as: 'user_approval', history: true)]
    public $userApprovalFilter = '';
    
    // Pagination - Keep page in URL
    #[Url(history: true)]
    public $page = 1;
    
    // Modal states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $selectedTicket = null;
    public $ticketToDelete = null;
    
    // Activity timeline
    public $showTimeline = false;
    public $timelineTicket = null;

    // Add these properties at the top with your other properties
    public $totalTicketsCount = 0;
    public $statusCounts = [];

    // Approval
    public $showApprovalPicModal = false;
    public $showApprovalUserModal = false;
    public $approval_status = '';
    public $approval_user_status = '';
    public $comment_manager = '';
    public $comment_user = '';

    public $perPage = 8;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'email_user' => 'required|email',
            'registration_no' => 'nullable|string|max:50',
            'description' => 'required|min:10',
            'files.*' => 'nullable|image|max:10240', // 10MB max
            'priority' => 'required|in:Low,Medium,Urgent,Critical',
            'assigned_role' => 'required|string',
            'category_id' => 'required|exists:tb_tc_category_tickets,id',
            'approval_status' => 'required|in:Approved,Rejected',
            'approval_user_status' => 'required|in:Approved,Rejected',
            'comment_manager' => 'required|string|min:5',
            'comment_user' => 'required|string|min:5',
        ];
    }

    protected $messages = [
        'title.required' => 'Title is required.',
        'title.min' => 'Title must be at least 3 characters.',
        'email_user.required' => 'Email is required.',
        'email_user.email' => 'Please enter a valid email address.',
        'description.required' => 'Description is required.',
        'description.min' => 'Description must be at least 10 characters.',
        'files.*.image' => 'File must be an image.',
        'files.*.max' => 'File size must not exceed 10MB.',
        'priority.required' => 'Priority is required.',
        'category_id.required' => 'Category is required.',
        'category_id.exists' => 'Selected category is invalid.',
        'approval_status.required' => 'Please select an approval status.',
        'approval_status.in' => 'Invalid approval status selected.',
        'comment_manager.required' => 'Comments are required for approval/rejection.',
        'comment_manager.min' => 'Comments must be at least 5 characters.',
        'approval_user_status.required' => 'Please select an approval status.',
        'approval_user_status.in' => 'Invalid approval status selected.',
        'comment_user.required' => 'Comments are required for approval/rejection.',
        'comment_user.min' => 'Comments must be at least 5 characters.',
    ];

    public function mount()
    {
        $this->perPage = 8;
        $this->email_user = Auth::user()->email ?? '';
        $this->ticket_number = Ticket::generateTicketNumber();
        $this->updateStatusCounts();
        $this->picApprovalFilter = request()->get('pic_approval', '');
        $this->userApprovalFilter = request()->get('user_approval', '');
    }

    // Open PIC Approval Modal
    public function openPicApprovalModal($id)
    {
        $this->selectedTicket = Ticket::findOrFail($id);
        
        // Check if user has permission to approve
        if (!auth()->user()->can('approve tickets', $this->selectedTicket)) {
            $this->dispatch('notify', message: 'You do not have permission to approve this ticket!', type: 'error');
            return;
        }
        
        // Check if already approved
        if ($this->selectedTicket->approval !== 'Waiting Approval') {
            $this->dispatch('notify', message: 'This ticket has already been processed!', type: 'warning');
            return;
        }
        
        $this->approval_status = '';
        $this->comment_manager = '';
        $this->showApprovalPicModal = true;
    }

    // Open User Approval Modal
    public function openUserApprovalModal($id)
    {
        $this->selectedTicket = Ticket::findOrFail($id);
        
        // Check if user has permission to check (requester)
        if (!auth()->user()->can('check tickets', $this->selectedTicket)) {
            $this->dispatch('notify', message: 'You do not have permission to approve this ticket!', type: 'error');
            return;
        }
        
        // Check if already approved
        if ($this->selectedTicket->approval_user !== 'Waiting Approval') {
            $this->dispatch('notify', message: 'This ticket has already been processed!', type: 'warning');
            return;
        }
        
        $this->approval_user_status = '';
        $this->comment_user = '';
        $this->showApprovalUserModal = true;
    }

    // Submit PIC Approval - tanpa email
    public function submitPicApproval()
    {
        $this->validate([
            'approval_status' => 'required|in:Approved,Rejected',
            'comment_manager' => 'required|string|min:5',
        ]);
        
        $ticket = $this->selectedTicket;
        
        // Double-check permission
        if (!auth()->user()->can('approve tickets', $ticket)) {
            $this->dispatch('notify', message: 'You do not have permission to approve this ticket!', type: 'error');
            $this->closeApprovalModal();
            return;
        }
        
        // Double-check status
        if ($ticket->approval !== 'Waiting Approval') {
            $this->dispatch('notify', message: 'This ticket has already been processed!', type: 'warning');
            $this->closeApprovalModal();
            return;
        }
        
        // Update ticket
        $ticket->approval = $this->approval_status;
        $ticket->approval_at = now();
        $ticket->comment_manager = $this->comment_manager;
        
        // If approved, update status to In Progress automatically
        if ($this->approval_status === 'Approved') {
            $ticket->status = 'In Progress';
        }
        
        $ticket->save();
        
        $message = $this->approval_status === 'Approved' 
            ? "Ticket #{$ticket->ticket_number} has been approved by PIC!" 
            : "Ticket #{$ticket->ticket_number} has been rejected by PIC.";
        
        $this->dispatch('notify', message: $message, type: 'success');
        $this->closeApprovalModal();
        $this->updateStatusCounts();
    }

    // Submit User Approval - tanpa email
    public function submitUserApproval()
    {
        $this->validate([
            'approval_user_status' => 'required|in:Approved,Rejected',
            'comment_user' => 'required|string|min:5',
        ]);
        
        $ticket = $this->selectedTicket;
        
        // Double-check permission
        if (!auth()->user()->can('check tickets', $ticket)) {
            $this->dispatch('notify', message: 'You do not have permission to approve this ticket!', type: 'error');
            $this->closeApprovalModal();
            return;
        }
        
        // Double-check status
        if ($ticket->approval_user !== 'Waiting Approval') {
            $this->dispatch('notify', message: 'This ticket has already been processed!', type: 'warning');
            $this->closeApprovalModal();
            return;
        }
        
        // Update ticket
        $ticket->approval_user = $this->approval_user_status;
        $ticket->approval_user_at = now();
        $ticket->comment_user = $this->comment_user;
        
        // If approved and PIC already approved, update status to Closed
        if ($this->approval_user_status === 'Approved' && $ticket->approval === 'Approved') {
            $ticket->status = 'Closed';
            $ticket->closed_at = now();
        }
        
        $ticket->save();
        
        $message = $this->approval_user_status === 'Approved' 
            ? "Ticket #{$ticket->ticket_number} has been approved by user!" 
            : "Ticket #{$ticket->ticket_number} has been rejected by user.";
        
        $this->dispatch('notify', message: $message, type: 'success');
        $this->closeApprovalModal();
        $this->updateStatusCounts();
    }

    // Hapus method sendApprovalEmail() karena tidak digunakan

    // Close approval modal
    public function closeApprovalModal()
    {
        $this->showApprovalPicModal = false;
        $this->showApprovalUserModal = false;
        $this->selectedTicket = null;
        $this->approval_status = '';
        $this->approval_user_status = '';
        $this->comment_manager = '';
        $this->comment_user = '';
    }

    // Add this method to your class
    public function setStatusFilter($status)
    {
        $this->statusFilter = $status;
        $this->updateStatusCounts();
    }

    private function updateStatusCounts()
    {
        $statusOptions = ['Open', 'In Progress', 'Pending', 'Closed'];
        $user = auth()->user();
        
        // Cek apakah user memiliki permission 'view tickets one user'
        $hasViewOneUser = $user->can('view tickets one user');
        
        foreach ($statusOptions as $status) {
            $query = Ticket::where('status', $status);
            
            // Jika memiliki view tickets one user, filter berdasarkan created_by
            if ($hasViewOneUser) {
                $query->where('created_by', $user->id);
            }
            
            // Apply approval filters
            if ($this->picApprovalFilter) {
                $query->where('approval', $this->picApprovalFilter);
            }
            
            if ($this->userApprovalFilter) {
                $query->where('approval_user', $this->userApprovalFilter);
            }
            
            $this->statusCounts[$status] = $query->count();
        }
        
        // Total count with filters applied
        $totalQuery = Ticket::query();
        
        // Jika memiliki view tickets one user, filter berdasarkan created_by
        if ($hasViewOneUser) {
            $totalQuery->where('created_by', $user->id);
        }
        
        if ($this->picApprovalFilter) {
            $totalQuery->where('approval', $this->picApprovalFilter);
        }
        if ($this->userApprovalFilter) {
            $totalQuery->where('approval_user', $this->userApprovalFilter);
        }
        $this->totalTicketsCount = $totalQuery->count();
    }

    public function render()
    {
        // Check permission untuk view tickets
        if (!auth()->user()->can('view tickets')) {
            abort(403, 'You do not have permission to view tickets.');
        }
        
        $user = auth()->user();
        
        // Cek apakah user memiliki permission 'view tickets one user'
        $hasViewOneUser = $user->can('view tickets one user');
        
        $tickets = Ticket::with(['category', 'creator', 'updater'])
            ->withCount('feedbacks')
            // Jika memiliki view tickets one user, filter berdasarkan created_by
            ->when($hasViewOneUser, function ($query) use ($user) {
                $query->where('created_by', $user->id);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('ticket_number', 'like', '%' . $this->search . '%')
                    ->orWhere('title', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->when($this->picApprovalFilter, function ($query) {
                $query->where('approval', $this->picApprovalFilter);
            })
            ->when($this->userApprovalFilter, function ($query) {
                $query->where('approval_user', $this->userApprovalFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $categories = CategoryTicket::orderBy('name')->get();
        $statusOptions = ['Open', 'In Progress', 'Pending', 'Closed'];

        return view('livewire.ticket.ticket-manager', [
            'tickets' => $tickets,
            'categories' => $categories,
            'statusOptions' => $statusOptions,
        ]);
    }

    // Wizard Navigation
    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'title' => 'required|min:3|max:255',
                'email_user' => 'required|email',
                'registration_no' => 'nullable|string|max:50',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'description' => 'required|min:10',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validate([
                'priority' => 'required|in:Low,Medium,Urgent,Critical',
                'category_id' => 'required|exists:tb_tc_category_tickets,id',
            ]);
        }
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    // File Management
    public function removeTempFile($index)
    {
        unset($this->tempFiles[$index]);
        $this->tempFiles = array_values($this->tempFiles);
    }

    public function updatedFiles()
    {
        foreach ($this->files as $file) {
            $this->tempFiles[] = $file;
        }
        $this->files = [];
    }

    // Create Ticket
    public function createTicket()
    {
        // Validasi hanya untuk field yang diperlukan saat create
        $this->validate([
            'title' => 'required|min:3|max:255',
            'email_user' => 'required|email',
            'registration_no' => 'nullable|string|max:50',
            'description' => 'required|min:10',
            'priority' => 'required|in:Low,Medium,Urgent,Critical',
            'category_id' => 'required|exists:tb_tc_category_tickets,id',
            'files.*' => 'nullable|image|max:10240',
        ]);
        
        try {
            // Handle file uploads
            $uploadedFiles = [];
            if (!empty($this->tempFiles)) {
                foreach ($this->tempFiles as $file) {
                    $path = $file->store('tickets', 'public');
                    $uploadedFiles[] = $path;
                }
            }

            $ticket = Ticket::create([
                'ticket_number' => $this->ticket_number, // Gunakan yang sudah digenerate
                'title' => $this->title,
                'description' => $this->description,
                'file' => $uploadedFiles,
                'status' => 'Open',
                'priority' => $this->priority,
                'category_id' => $this->category_id,
                'assigned_role' => $this->assigned_role,
                'email_user' => $this->email_user,
                'registration_no' => $this->registration_no,
                'approval' => 'Waiting Approval',
                'approval_user' => 'Waiting Approval',
                'created_by' => auth()->id(),
            ]);

            // Kirim email (wrap in try-catch)
            try {
                $this->sendTicketEmails($ticket);
            } catch (\Exception $e) {
                \Log::error('Failed to send email: ' . $e->getMessage());
            }

            // Reset form
            $this->resetForm();
            $this->showCreateModal = false;
            
            // Dispatch success message
            $this->dispatch('notify', message: "Ticket #{$ticket->ticket_number} created successfully!", type: 'success');
            
            // Refresh data
            $this->updateStatusCounts();
            
        } catch (\Exception $e) {
            \Log::error('Ticket creation failed: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to create ticket: ' . $e->getMessage(), type: 'error');
        }
    }

    protected function sendTicketEmails($ticket)
    {
        try {
            // Send to default email
            Mail::to('bonizar@siix-global.com')->send(new TicketCreated($ticket));
            
            // Send based on assigned role
            $emailToSend = null;
            switch ($ticket->assigned_role) {
                case 'ADMINUTILITY':
                    $emailToSend = 'sek.utility@siix-global.com';
                    break;
                case 'ADMINESD':
                    $emailToSend = 'sek.esd@siix-global.com';
                    break;
            }
            
            if ($emailToSend) {
                Mail::to($emailToSend)->send(new TicketCreated($ticket));
            }
            
            // Send to user
            if ($ticket->email_user) {
                Mail::to($ticket->email_user)->send(new TicketCreatedForUser($ticket));
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Failed to send ticket email: ' . $e->getMessage());
        }
    }

    // View Ticket
    public function viewTicket($id)
    {
        $this->selectedTicket = Ticket::with(['category', 'creator', 'updater', 'feedbacks.user'])
            ->findOrFail($id);
        $this->showViewModal = true;
    }

    // Edit Ticket
    public function editTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Check if ticket can be edited
        if (in_array($ticket->status, ['In Progress', 'Pending', 'Closed'])) {
            $this->dispatch('notify', message: 'Cannot edit ticket that is already in progress, pending, or closed!', type: 'error');
            return;
        }
        
        if ($ticket->created_at < Carbon::now()->subHours(24)) {
            $this->dispatch('notify', message: 'Cannot edit ticket older than 24 hours!', type: 'error');
            return;
        }
        
        $this->selectedTicket = $ticket;
        $this->title = $ticket->title;
        $this->description = $ticket->description;
        $this->priority = $ticket->priority;
        $this->category_id = $ticket->category_id;
        $this->assigned_role = $ticket->assigned_role;
        $this->email_user = $ticket->email_user;
        $this->registration_no = $ticket->registration_no;
        
        $this->showEditModal = true;
    }

    public function updateTicket()
    {
        $this->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'priority' => 'required|in:Low,Medium,Urgent,Critical',
            'category_id' => 'required|exists:tb_tc_category_tickets,id',
        ]);
        
        $ticket = Ticket::findOrFail($this->selectedTicket->id);
        
        $ticket->update([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'category_id' => $this->category_id,
            'assigned_role' => $this->assigned_role,
            'email_user' => $this->email_user,
            'registration_no' => $this->registration_no,
        ]);
        
        $this->resetForm();
        $this->showEditModal = false;
        
        $this->dispatch('notify', message: "Ticket #{$ticket->ticket_number} updated successfully!", type: 'success');
    }

    // Delete Ticket
    public function confirmDelete($id)
    {
        $this->ticketToDelete = Ticket::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteTicket()
    {
        $ticketNumber = $this->ticketToDelete->ticket_number;
        
        // Delete files
        if ($this->ticketToDelete->file) {
            foreach ($this->ticketToDelete->file as $file) {
                Storage::disk('public')->delete($file);
            }
        }
        
        $this->ticketToDelete->delete();
        
        $this->showDeleteModal = false;
        $this->ticketToDelete = null;
        
        $this->dispatch('notify', message: "Ticket #{$ticketNumber} deleted successfully!", type: 'success');
    }

    // Status Update
    public function updateStatus($id, $status)
    {
        $ticket = Ticket::findOrFail($id);
        
        if (!auth()->user()->can('update status', $ticket)) {
            $this->dispatch('notify', message: 'You do not have permission to update ticket status!', type: 'error');
            return;
        }
        
        $ticket->status = $status;
        
        if ($status === 'Closed') {
            $ticket->closed_at = Carbon::now('Asia/Jakarta');
        } else {
            $ticket->closed_at = null;
        }
        
        $ticket->save();
        
        $this->dispatch('notify', message: "Ticket status updated to {$status}!", type: 'success');
    }

    // Approval Actions
    public function approveTicket($id, $type = 'pic')
    {
        $ticket = Ticket::findOrFail($id);
        
        if ($type === 'pic') {
            if (!auth()->user()->can('approve', $ticket)) {
                $this->dispatch('notify', message: 'You do not have permission to approve this ticket!', type: 'error');
                return;
            }
            
            $ticket->approval = 'Approved';
            $ticket->approval_at = now();
        } else {
            $ticket->approval_user = 'Approved';
            $ticket->approval_user_at = now();
        }
        
        $ticket->save();
        
        $this->dispatch('notify', message: 'Ticket approved successfully!', type: 'success');
    }

    public function rejectTicket($id, $type = 'pic')
    {
        $ticket = Ticket::findOrFail($id);
        
        if ($type === 'pic') {
            if (!auth()->user()->can('approve', $ticket)) {
                $this->dispatch('notify', message: 'You do not have permission to reject this ticket!', type: 'error');
                return;
            }
            
            $ticket->approval = 'Rejected';
            $ticket->approval_at = now();
        } else {
            $ticket->approval_user = 'Rejected';
            $ticket->approval_user_at = now();
        }
        
        $ticket->save();
        
        $this->dispatch('notify', message: 'Ticket rejected!', type: 'warning');
    }

    // Activity Timeline
    public function showTimelineModal($id)
    {
        $this->timelineTicket = Ticket::findOrFail($id);
        $this->showTimeline = true;
    }

    // Reset Form
    public function resetForm()
    {
        $this->reset([
            'title', 'description', 'priority', 'category_id', 'assigned_role',
            'email_user', 'registration_no', 'files', 'tempFiles', 'currentStep'
        ]);
        $this->currentStep = 1;
        $this->ticket_number = Ticket::generateTicketNumber();
        $this->email_user = Auth::user()->email ?? '';
        $this->assigned_role = 'ADMINESD';
        $this->resetValidation();
    }

    // Add this method to your class
    public function clearFilters()
    {
        $this->search = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->statusFilter = '';
        $this->picApprovalFilter = '';
        $this->userApprovalFilter = '';
        
        $this->dispatch('notify', message: 'All filters cleared!', type: 'info');
}

    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showViewModal = false;
        $this->showDeleteModal = false;
        $this->showTimeline = false;
        $this->selectedTicket = null;
        $this->ticketToDelete = null;
        $this->timelineTicket = null;
        $this->resetForm();
    }
}