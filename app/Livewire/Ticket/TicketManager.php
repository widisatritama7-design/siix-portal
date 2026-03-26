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
use App\Mail\TicketCreated;
use App\Mail\TicketCreatedForUser;
use Carbon\Carbon;

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
    
    // Search & Filters
    public $search = '';
    public $statusFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    
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
            'category_id' => 'required|exists:category_tickets,id',
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
    ];

    public function mount()
    {
        $this->email_user = Auth::user()->email ?? '';
        $this->ticket_number = Ticket::generateTicketNumber();
    }

    public function render()
    {
        $tickets = Ticket::with(['category', 'creator', 'updater'])
            ->withCount('feedbacks')
            ->when($this->search, function ($query) {
                $query->where('ticket_number', 'like', '%' . $this->search . '%')
                    ->orWhere('title', 'like', '%' . $this->search . '%');
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
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'description' => 'required|min:10',
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
        $this->validate();
        
        // Handle file uploads
        $uploadedFiles = [];
        foreach ($this->tempFiles as $file) {
            $path = $file->store('tickets/' . date('Y/m/d'), 'public');
            $uploadedFiles[] = $path;
        }

        $ticket = Ticket::create([
            'ticket_number' => Ticket::generateTicketNumber(),
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
        ]);

        // Send emails
        $this->sendTicketEmails($ticket);

        // Reset form
        $this->resetForm();
        $this->showCreateModal = false;
        
        $this->dispatch('notify', message: "Ticket #{$ticket->ticket_number} created successfully!", type: 'success');
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
            'category_id' => 'required|exists:category_tickets,id',
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
            'email_user', 'registration_no', 'files', 'tempFiles'
        ]);
        $this->currentStep = 1;
        $this->ticket_number = Ticket::generateTicketNumber();
        $this->email_user = Auth::user()->email ?? '';
        $this->assigned_role = 'ADMINESD';
        $this->resetValidation();
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