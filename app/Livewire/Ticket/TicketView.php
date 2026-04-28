<?php

namespace App\Livewire\Ticket;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\Ticket\FeedbackCreated;
use App\Mail\Ticket\FeedbackCreatedForUser;
use Carbon\Carbon;

class TicketView extends Component
{
    use WithFileUploads;

    public $ticket;
    public $ticketId;
    
    // Feedback form
    public $comments;
    public $photos = [];
    public $tempPhotos = [];
    public $files = [];
    public $tempFiles = [];
    public $status;
    
    // Modal states
    public $showFeedbackModal = false;
    public $showEditFeedbackModal = false;
    public $showDeleteFeedbackModal = false;
    public $editingFeedback = null;
    public $feedbackToDelete = null;
    public $editStatus;
    public $editComments;

    // Image modal
    public $showImageModal = false;
    public $imageModalUrl = '';
    public $imageModalTitle = '';
    
    // Edit form properties
    public $editPhotos = [];
    public $editTempPhotos = [];
    public $editFiles = [];
    public $editTempFiles = [];
    public $photosToDelete = [];
    public $filesToDelete = [];
    public $existingPhotos = [];
    public $existingFiles = [];
    
    protected function rules()
    {
        return [
            'comments' => 'required|min:3',
            'photos.*' => 'nullable|image|max:10240',
            'files.*' => 'nullable|mimes:pdf,doc,docx,xlsx,xls|max:10240',
            'status' => 'required|in:Open,In Progress,Pending,Closed',
        ];
    }
    
    protected $messages = [
        'comments.required' => 'Please enter your feedback.',
        'comments.min' => 'Feedback must be at least 3 characters.',
        'photos.*.image' => 'File must be an image.',
        'photos.*.max' => 'Image size must not exceed 10MB.',
        'files.*.mimes' => 'File must be PDF, DOC, DOCX, XLSX, or XLS.',
        'files.*.max' => 'File size must not exceed 10MB.',
        'status.required' => 'Please select a status.',
    ];

    public function openImageModal($url, $title)
    {
        $this->imageModalUrl = $url;
        $this->imageModalTitle = $title;
        $this->showImageModal = true;
    }

    public function closeImageModal()
    {
        $this->showImageModal = false;
        $this->imageModalUrl = '';
        $this->imageModalTitle = '';
    }

    public function mount($id)
    {
        $this->ticketId = $id;
        $this->refreshTicket();
        $this->status = $this->ticket->status;
    }
    
    public function render()
    {
        return view('livewire.ticket.ticket-view', [
            'ticket' => $this->ticket,
            'feedbacks' => $this->ticket->feedbacks()->with('user')->orderBy('created_at', 'desc')->get(),
        ])->layout('layouts.app');
    }
    
    public function refreshTicket()
    {
        $this->ticket = Ticket::with(['category', 'creator', 'updater', 'feedbacks.user'])
            ->findOrFail($this->ticketId);
    }
    
    public function openFeedbackModal()
    {
        if ($this->ticket->status === 'Closed') {
            $this->dispatch('notify', message: 'Cannot add feedback to closed ticket!', type: 'error');
            return;
        }
        
        $this->reset(['comments', 'photos', 'tempPhotos', 'files', 'tempFiles']);
        $this->status = $this->ticket->status;
        $this->showFeedbackModal = true;
    }
    
    public function submitFeedback()
    {
        $this->validate();
        
        if ($this->ticket->status === 'Closed') {
            $this->dispatch('notify', message: 'Cannot add feedback to closed ticket!', type: 'error');
            $this->closeModal();
            return;
        }
        
        // Upload photos - LANGSUNG KE FOLDER FEEDBACK
        $uploadedPhotos = [];
        if (!empty($this->tempPhotos)) {
            foreach ($this->tempPhotos as $photo) {
                $path = $photo->store('feedback', 'public');
                $uploadedPhotos[] = $path;
            }
        }
        
        // Upload files - LANGSUNG KE FOLDER FEEDBACK
        $uploadedFiles = [];
        if (!empty($this->tempFiles)) {
            foreach ($this->tempFiles as $file) {
                $path = $file->store('feedback', 'public');
                $uploadedFiles[] = $path;
            }
        }
        
        $feedback = Feedback::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => Auth::id(),
            'status' => $this->status,
            'comments' => $this->comments,
            'photo' => $uploadedPhotos,  // LANGSUNG ARRAY, BUKAN json_encode()
            'file' => $uploadedFiles,    // LANGSUNG ARRAY, BUKAN json_encode()
            'email_user' => $this->ticket->email_user,
        ]);
        
        // Update ticket status if changed
        if ($this->ticket->status !== $this->status) {
            $this->ticket->status = $this->status;
            if ($this->status === 'Closed') {
                $this->ticket->closed_at = Carbon::now('Asia/Jakarta');
            } else {
                $this->ticket->closed_at = null;
            }
            $this->ticket->save();
        }
        
        // Send emails
        $this->sendFeedbackEmails($feedback);
        
        // Reset form and close modal
        $this->reset(['comments', 'photos', 'tempPhotos', 'files', 'tempFiles']);
        $this->showFeedbackModal = false;
        $this->refreshTicket();
        
        $this->dispatch('notify', message: 'Feedback submitted successfully!', type: 'success');
    }
    
    public function editFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        
        if (Carbon::now()->diffInHours($feedback->created_at) >= 24) {
            $this->dispatch('notify', message: 'Cannot edit feedback older than 24 hours!', type: 'error');
            return;
        }
        
        $this->editingFeedback = $feedback;
        $this->editStatus = $feedback->status;
        $this->editComments = $feedback->comments;
        
        // Initialize existing photos and files from feedback
        $this->existingPhotos = is_array($feedback->photo) ? $feedback->photo : json_decode($feedback->photo, true);
        $this->existingFiles = is_array($feedback->file) ? $feedback->file : json_decode($feedback->file, true);
        $this->existingPhotos = $this->existingPhotos ?: [];
        $this->existingFiles = $this->existingFiles ?: [];
        
        // Reset edit properties
        $this->editPhotos = [];
        $this->editTempPhotos = [];
        $this->editFiles = [];
        $this->editTempFiles = [];
        $this->photosToDelete = [];
        $this->filesToDelete = [];
        
        $this->showEditFeedbackModal = true;
    }
    
    public function updateFeedback()
    {
        $this->validate([
            'editStatus' => 'required|in:Open,In Progress,Pending,Closed',
            'editComments' => 'required|min:3',
        ]);
        
        $feedback = $this->editingFeedback;
        
        // Check if feedback can be edited (not older than 24 hours)
        if (Carbon::now()->diffInHours($feedback->created_at) >= 24) {
            $this->dispatch('notify', message: 'Cannot edit feedback older than 24 hours!', type: 'error');
            $this->closeEditFeedbackModal();
            return;
        }
        
        // Delete removed photos from storage
        if (!empty($this->photosToDelete)) {
            foreach ($this->photosToDelete as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }
        
        // Delete removed files from storage
        if (!empty($this->filesToDelete)) {
            foreach ($this->filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        }
        
        // Add new photos - LANGSUNG KE FOLDER FEEDBACK
        $newPhotos = [];
        if (!empty($this->editTempPhotos)) {
            foreach ($this->editTempPhotos as $photo) {
                $path = $photo->store('feedback', 'public');
                $newPhotos[] = $path;
            }
        }
        
        // Add new files - LANGSUNG KE FOLDER FEEDBACK
        $newFiles = [];
        if (!empty($this->editTempFiles)) {
            foreach ($this->editTempFiles as $file) {
                $path = $file->store('feedback', 'public');
                $newFiles[] = $path;
            }
        }
        
        // Merge existing (that weren't deleted) and new
        $allPhotos = array_merge($this->existingPhotos, $newPhotos);
        $allFiles = array_merge($this->existingFiles, $newFiles);
        
        // Update feedback - LANGSUNG ARRAY, BUKAN json_encode()
        $feedback->update([
            'status' => $this->editStatus,
            'comments' => $this->editComments,
            'photo' => $allPhotos,
            'file' => $allFiles,
        ]);
        
        // Update ticket status if needed
        if ($feedback->ticket->status != $this->editStatus) {
            $feedback->ticket->status = $this->editStatus;
            if ($this->editStatus === 'Closed') {
                $feedback->ticket->closed_at = Carbon::now('Asia/Jakarta');
            } else {
                $feedback->ticket->closed_at = null;
            }
            $feedback->ticket->save();
        }
        
        $this->closeEditFeedbackModal();
        $this->refreshTicket();
        $this->dispatch('notify', message: 'Feedback updated successfully!', type: 'success');
    }
    
    public function confirmDeleteFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        
        if (Carbon::now()->diffInHours($feedback->created_at) >= 24) {
            $this->dispatch('notify', message: 'Cannot delete feedback older than 24 hours!', type: 'error');
            return;
        }
        
        $this->feedbackToDelete = $feedback;
        $this->showDeleteFeedbackModal = true;
    }
    
    public function deleteFeedback()
    {
        $feedback = $this->feedbackToDelete;
        
        if (Carbon::now()->diffInHours($feedback->created_at) >= 24) {
            $this->dispatch('notify', message: 'Cannot delete feedback older than 24 hours!', type: 'error');
            $this->closeDeleteFeedbackModal();
            return;
        }
        
        // Delete photos
        if ($feedback->photo) {
            $photos = is_array($feedback->photo) ? $feedback->photo : json_decode($feedback->photo, true);
            if ($photos && is_array($photos)) {
                foreach ($photos as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }
        
        // Delete files
        if ($feedback->file) {
            $files = is_array($feedback->file) ? $feedback->file : json_decode($feedback->file, true);
            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        }
        
        $feedback->delete();
        
        $this->closeDeleteFeedbackModal();
        $this->refreshTicket();
        $this->dispatch('notify', message: 'Feedback deleted successfully!', type: 'success');
    }
    
    // Remove methods
    public function removeTempPhoto($index)
    {
        unset($this->tempPhotos[$index]);
        $this->tempPhotos = array_values($this->tempPhotos);
    }
    
    public function removeTempFile($index)
    {
        unset($this->tempFiles[$index]);
        $this->tempFiles = array_values($this->tempFiles);
    }
    
    public function removeEditTempPhoto($index)
    {
        unset($this->editTempPhotos[$index]);
        $this->editTempPhotos = array_values($this->editTempPhotos);
    }
    
    public function removeEditTempFile($index)
    {
        unset($this->editTempFiles[$index]);
        $this->editTempFiles = array_values($this->editTempFiles);
    }
    
    public function removeExistingPhoto($photoPath)
    {
        // Add to delete list
        $this->photosToDelete[] = $photoPath;
        
        // Remove from existing photos array
        $this->existingPhotos = array_values(array_filter($this->existingPhotos, function($photo) use ($photoPath) {
            return $photo !== $photoPath;
        }));
    }
    
    public function removeExistingFile($filePath)
    {
        // Add to delete list
        $this->filesToDelete[] = $filePath;
        
        // Remove from existing files array
        $this->existingFiles = array_values(array_filter($this->existingFiles, function($file) use ($filePath) {
            return $file !== $filePath;
        }));
    }
    
    // Updated methods for file uploads
    public function updatedPhotos()
    {
        foreach ($this->photos as $photo) {
            $this->tempPhotos[] = $photo;
        }
        $this->photos = [];
    }
    
    public function updatedFiles()
    {
        foreach ($this->files as $file) {
            $this->tempFiles[] = $file;
        }
        $this->files = [];
    }
    
    public function updatedEditPhotos()
    {
        foreach ($this->editPhotos as $photo) {
            $this->editTempPhotos[] = $photo;
        }
        $this->editPhotos = [];
    }
    
    public function updatedEditFiles()
    {
        foreach ($this->editFiles as $file) {
            $this->editTempFiles[] = $file;
        }
        $this->editFiles = [];
    }
    
    // Close modal methods
    public function closeModal()
    {
        $this->showFeedbackModal = false;
        $this->reset(['comments', 'photos', 'tempPhotos', 'files', 'tempFiles']);
    }
    
    public function closeEditFeedbackModal()
    {
        $this->showEditFeedbackModal = false;
        $this->editingFeedback = null;
        $this->editStatus = null;
        $this->editComments = null;
        $this->editPhotos = [];
        $this->editTempPhotos = [];
        $this->editFiles = [];
        $this->editTempFiles = [];
        $this->photosToDelete = [];
        $this->filesToDelete = [];
        $this->existingPhotos = [];
        $this->existingFiles = [];
    }
    
    public function closeDeleteFeedbackModal()
    {
        $this->showDeleteFeedbackModal = false;
        $this->feedbackToDelete = null;
    }
    
    public function formatDate($date)
    {
        if (empty($date)) {
            return '-';
        }
        
        if ($date instanceof Carbon) {
            return $date->format('d M Y H:i');
        }
        
        try {
            return Carbon::parse($date)->format('d M Y H:i');
        } catch (\Exception $e) {
            return $date;
        }
    }
    
    protected function sendFeedbackEmails($feedback)
    {
        try {
            \Log::info('Sending feedback emails for feedback ID: ' . $feedback->id);
            
            Mail::to('sek.esd@siix-global.com')->send(new FeedbackCreated($feedback));
            \Log::info('Email sent to sek.esd@siix-global.com');
            
            $emailToSend = null;
            switch ($this->ticket->assigned_role) {
                case 'ADMINUTILITY':
                    $emailToSend = 'sek.utility@siix-global.com';
                    break;
                case 'ADMINESD':
                    $emailToSend = 'sek.esd@siix-global.com';
                    break;
                case 'ADMINHR':
                    $emailToSend = 'hr@siix-global.com';
                    break;
                case 'ADMINGA':
                    $emailToSend = 'ga@siix-global.com';
                    break;
            }
            
            if ($emailToSend) {
                Mail::to($emailToSend)->send(new FeedbackCreated($feedback));
                \Log::info('Email sent to assigned role: ' . $emailToSend);
            }
            
            if ($this->ticket->email_user) {
                Mail::to($this->ticket->email_user)->send(new FeedbackCreatedForUser($feedback));
                \Log::info('Email sent to user: ' . $this->ticket->email_user);
            }
            
            \Log::info('All feedback emails sent successfully');
            
        } catch (\Exception $e) {
            \Log::error('Failed to send feedback email: ' . $e->getMessage());
        }
    }
    
    public function getFileUrl($path)
    {
        return Storage::url($path);
    }
}