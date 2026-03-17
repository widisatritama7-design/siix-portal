<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    public $users;
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public $search = '';
    public $modalTitle = 'Add New User';
    public $userIdToDelete = null;
    public $showDeleteModal = false;
    public $userToDelete = null;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    protected $messages = [
        'name.required' => 'The name field is required.',
        'name.min' => 'The name must be at least 3 characters.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'password.required' => 'The password field is required.',
        'password.min' => 'The password must be at least 8 characters.',
        'password.confirmed' => 'The password confirmation does not match.',
    ];

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $this->users = $query->latest()->get();
    }

    public function updatedSearch()
    {
        $this->loadUsers();
    }

    public function save()
    {
        if ($this->user_id) {
            // Update mode
            $this->validate([
                'name' => 'required|min:3|max:255',
                'email' => 'required|email|unique:users,email,' . $this->user_id,
                'password' => 'nullable|min:8|confirmed',
            ]);

            $user = User::findOrFail($this->user_id);
            
            $data = [
                'name' => $this->name,
                'email' => $this->email,
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $user->update($data);
            
            $message = 'User updated successfully!';
        } else {
            // Create mode
            $this->validate();

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            
            $message = 'User created successfully!';
        }

        // Reset form
        $this->reset(['user_id', 'name', 'email', 'password', 'password_confirmation']);
        
        // Load ulang users
        $this->loadUsers();
        
        // Dispatch event untuk notifikasi
        $this->dispatch('notify', message: $message);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->modalTitle = 'Edit User';
    }

    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);
        $this->userToDelete = $user;
        $this->userIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $user = User::findOrFail($this->userIdToDelete);
        $userName = $user->name;
        $user->delete();

        $this->userIdToDelete = null;
        $this->userToDelete = null;
        $this->showDeleteModal = false;
        
        // Load ulang users
        $this->loadUsers();
        
        $this->dispatch('notify', message: "User '{$userName}' has been deleted successfully!");
    }

    public function cancelDelete()
    {
        $this->userIdToDelete = null;
        $this->userToDelete = null;
        $this->showDeleteModal = false;
    }

    public function render()
    {
        return view('livewire.user.user-management');
    }
}