<?php
// app/Livewire/NotificationManager.php

namespace App\Livewire;

use App\Models\SiteNotification;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;

class NotificationManager extends Component
{
    use WithPagination;

    public $notificationId;
    public $icon;
    public $color = 'yellow'; // Tambahkan ini dengan default value
    public $message;
    public $button_text;
    public $button_url;
    public $is_active = true;
    public $display_order = 0;
    
    public $isEditing = false;
    public $search = '';
    public $deleteId = null;
    public $showModal = false;
    public $showDeleteModal = false;
    
    protected $rules = [
        'icon' => 'nullable|string|max:255',
        'color' => 'required|in:yellow,blue,green,red,purple,pink,indigo,gray', // Tambahkan validasi color
        'message' => 'required|string',
        'button_text' => 'nullable|string|max:255',
        'button_url' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'display_order' => 'integer|min:0'
    ];

    public function render()
    {
        $notifications = SiteNotification::when($this->search, function($query) {
            $query->where('message', 'like', '%' . $this->search . '%');
        })->orderBy('display_order')->paginate(10);

        return view('livewire.settings.notification-manager', compact('notifications'));
    }

    public function resetForm()
    {
        $this->reset(['notificationId', 'icon', 'message', 'button_text', 'button_url', 'is_active', 'display_order', 'isEditing']);
        $this->color = 'yellow'; // Reset ke default
        $this->resetValidation();
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $notification = SiteNotification::findOrFail($id);
        
        $this->notificationId = $notification->id;
        $this->icon = $notification->icon;
        $this->color = $notification->color ?? 'yellow'; // Tambahkan ini
        $this->message = $notification->message;
        $this->button_text = $notification->button_text;
        $this->button_url = $notification->button_url;
        $this->is_active = $notification->is_active;
        $this->display_order = $notification->display_order;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $notification = SiteNotification::find($this->notificationId);
            $notification->update([
                'icon' => $this->icon,
                'color' => $this->color, // Tambahkan ini
                'message' => $this->message,
                'button_text' => $this->button_text,
                'button_url' => $this->button_url,
                'is_active' => $this->is_active,
                'display_order' => $this->display_order
            ]);
            Flux::toast('Notification updated successfully!', 'success');
        } else {
            SiteNotification::create([
                'icon' => $this->icon,
                'color' => $this->color, // Tambahkan ini
                'message' => $this->message,
                'button_text' => $this->button_text,
                'button_url' => $this->button_url,
                'is_active' => $this->is_active,
                'display_order' => $this->display_order
            ]);
            Flux::toast('Notification created successfully!', 'success');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteConfirmed()
    {
        if ($this->deleteId) {
            SiteNotification::findOrFail($this->deleteId)->delete();
            Flux::toast('Notification deleted successfully!', 'success');
            $this->deleteId = null;
        }
        $this->closeModal();
    }

    public function toggleStatus($id)
    {
        $notification = SiteNotification::findOrFail($id);
        $notification->update(['is_active' => !$notification->is_active]);
        
        Flux::toast('Status updated successfully!', 'success');
    }
}