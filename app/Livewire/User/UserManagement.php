<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination;

    public $user_id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRoles = [];

    public $search = '';
    public $modalTitle = 'Add New User';
    public $userToDelete = null;

    protected function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'selectedRoles' => 'array',
        ];

        if ($this->user_id) {
            $rules['password'] = 'nullable|min:8|confirmed';
        } else {
            $rules['password'] = 'required|min:8|confirmed';
        }

        return $rules;
    }

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

    public function resetForm()
    {
        $this->reset(['user_id', 'name', 'email', 'password', 'password_confirmation', 'selectedRoles']);
        $this->modalTitle = 'Add New User';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        // CEK AKSES
        if ($this->user_id) {
            if (!auth()->user()->can('edit users')) {
                $this->dispatch('notify', message: 'You do not have permission to edit users!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create users')) {
                $this->dispatch('notify', message: 'You do not have permission to create users!', type: 'error');
                return;
            }
        }

        $this->validate();

        if ($this->user_id) {
            $user = User::findOrFail($this->user_id);
            
            $data = [
                'name' => $this->name,
                'email' => $this->email,
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $user->update($data);
            $user->syncRoles($this->selectedRoles);
            
            $message = 'User updated successfully!';
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            
            if (!empty($this->selectedRoles)) {
                $user->assignRole($this->selectedRoles);
            }
            
            $message = 'User created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
    }

    public function edit($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('edit users')) {
            $this->dispatch('notify', message: 'You do not have permission to edit users!', type: 'error');
            return;
        }

        $user = User::with('roles')->findOrFail($id);

        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->modalTitle = 'Edit User';
    }

    public function confirmDelete($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('delete users')) {
            $this->dispatch('notify', message: 'You do not have permission to delete users!', type: 'error');
            return;
        }

        $user = User::findOrFail($id);
        
        if ($user->hasRole('super-admin')) {
            $this->dispatch('notify', message: 'Cannot delete super admin user!', type: 'error');
            return;
        }

        $this->userToDelete = $user;
    }

    public function delete()
    {
        if (!auth()->user()->can('delete users')) {
            $this->dispatch('notify', message: 'You do not have permission to delete users!', type: 'error');
            return;
        }

        $user = User::findOrFail($this->userToDelete->id);
        $userName = $user->name;
        $user->delete();

        $this->userToDelete = null;
        
        $this->dispatch('notify', message: "User '{$userName}' has been deleted successfully!");
    }

    public function cancelDelete()
    {
        $this->userToDelete = null;
    }

    public function render()
    {
        // CEK AKSES VIEW
        if (!auth()->user()->can('view users')) {
            abort(403, 'Unauthorized access.');
        }

        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        $roles = Role::orderBy('name')->get();

        return view('livewire.user.user-management', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}