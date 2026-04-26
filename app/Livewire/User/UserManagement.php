<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class UserManagement extends Component
{
    use WithPagination;

    public $nik;
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRoles = [];

    public $search = '';
    public $modalTitle = 'Add New User';
    public $userToDelete = null;
    
    // Bulk action properties
    public $selectedUsers = [];
    public $selectAll = false;
    public $bulkSelectedRoles = []; // Array untuk multiple roles
    public $bulkActionType = 'assign'; // 'assign' or 'remove'
    public $showBulkModal = false;

    protected function rules()
    {
        $rules = [
            'nik' => [
                'required',
                'numeric',
                Rule::unique('users', 'nik')->ignore($this->user_id),
            ],
            'name' => 'required|min:3|max:255',
            'email' => 'nullable|email|max:255',
            'selectedRoles' => 'array|nullable',
        ];
    
        if ($this->user_id) {
            $rules['password'] = 'nullable|min:8|confirmed';
            $rules['email'] = 'nullable|email|max:255|unique:users,email,' . $this->user_id;
        } else {
            $rules['password'] = 'required|min:8|confirmed';
            $rules['email'] = 'nullable|email|max:255|unique:users,email';
        }
    
        return $rules;
    }

    protected $messages = [
        'nik.required' => 'NIK wajib diisi.',
        'nik.numeric' => 'NIK harus berupa angka.',
        'nik.unique' => 'NIK ini sudah terdaftar.',
        'name.required' => 'Nama wajib diisi.',
        'name.min' => 'Nama minimal 3 karakter.',
        'name.max' => 'Nama maksimal 255 karakter.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar.',
        'email.max' => 'Email maksimal 255 karakter.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'selectedRoles.array' => 'Format roles tidak valid.',
    ];

    public function resetForm()
    {
        $this->reset(['user_id', 'nik', 'name', 'email', 'password', 'password_confirmation', 'selectedRoles']);
        $this->modalTitle = 'Add New User';
        $this->resetValidation();
    
        $this->dispatch('open-modal', modal: 'user-form-modal');
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->resetBulkSelection();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedUsers = $this->getUsers()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function updatedSelectedUsers()
    {
        $this->selectAll = count($this->selectedUsers) === $this->getUsers()->count();
    }

    protected function getUsers()
    {
        return User::with('roles')
            ->when($this->search, function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('nik', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function resetBulkSelection()
    {
        $this->selectedUsers = [];
        $this->selectAll = false;
        $this->bulkSelectedRoles = [];
        $this->bulkActionType = 'assign';
    }

    public function openBulkModal()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('notify', message: 'Please select at least one user!', type: 'warning');
            return;
        }

        if (!auth()->user()->can('edit users')) {
            $this->dispatch('notify', message: 'You do not have permission to edit users!', type: 'error');
            return;
        }

        $this->bulkSelectedRoles = [];
        $this->bulkActionType = 'assign';
        $this->showBulkModal = true;
        $this->dispatch('open-modal', modal: 'bulk-action-modal');
    }

    public function assignBulkRoles()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('notify', message: 'No users selected!', type: 'warning');
            return;
        }

        if (empty($this->bulkSelectedRoles)) {
            $this->dispatch('notify', message: 'Please select at least one role to assign!', type: 'warning');
            return;
        }

        try {
            $users = User::whereIn('id', $this->selectedUsers)->get();
            $count = 0;
            $skipped = 0;
            $assignedRoles = [];

            foreach ($this->bulkSelectedRoles as $roleName) {
                $role = Role::where('name', $roleName)->first();
                if ($role) {
                    $assignedRoles[] = $roleName;
                }
            }

            foreach ($users as $user) {
                $userAssignCount = 0;
                
                foreach ($assignedRoles as $roleName) {
                    // Skip super admin if current user is not super admin
                    if ($roleName === 'super-admin' && !auth()->user()->hasRole('super-admin')) {
                        $skipped++;
                        continue;
                    }

                    // Check if user already has the role
                    if (!$user->hasRole($roleName)) {
                        $user->assignRole($roleName);
                        $count++;
                        $userAssignCount++;
                    }
                }
            }

            $rolesList = implode(', ', $assignedRoles);
            $message = "Roles [{$rolesList}] assigned to {$count} user(s)";
            if ($skipped > 0) {
                $message .= " (Skipped {$skipped} super-admin role assignments)";
            }
            
            $this->dispatch('notify', message: $message, type: 'success');
            
            // Reset bulk selection
            $this->resetBulkSelection();
            $this->showBulkModal = false;
            $this->dispatch('close-modal', modal: 'bulk-action-modal');
            
        } catch (\Exception $e) {
            \Log::error('Bulk role assignment error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error assigning roles: ' . $e->getMessage(), type: 'error');
        }
    }

    public function removeBulkRoles()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('notify', message: 'No users selected!', type: 'warning');
            return;
        }

        if (empty($this->bulkSelectedRoles)) {
            $this->dispatch('notify', message: 'Please select at least one role to remove!', type: 'warning');
            return;
        }

        try {
            $users = User::whereIn('id', $this->selectedUsers)->get();
            $count = 0;
            $skipped = 0;
            $removedRoles = [];

            foreach ($this->bulkSelectedRoles as $roleName) {
                $role = Role::where('name', $roleName)->first();
                if ($role) {
                    $removedRoles[] = $roleName;
                }
            }

            foreach ($users as $user) {
                foreach ($removedRoles as $roleName) {
                    // Prevent removing super-admin role from super admin users
                    if ($user->hasRole('super-admin') && $roleName === 'super-admin') {
                        $skipped++;
                        continue;
                    }

                    if ($user->hasRole($roleName)) {
                        $user->removeRole($roleName);
                        $count++;
                    }
                }
            }

            $rolesList = implode(', ', $removedRoles);
            $message = "Roles [{$rolesList}] removed from {$count} user(s)";
            if ($skipped > 0) {
                $message .= " (Skipped {$skipped} super-admin role removals)";
            }
            
            $this->dispatch('notify', message: $message, type: 'success');
            
            // Reset bulk selection
            $this->resetBulkSelection();
            $this->showBulkModal = false;
            $this->dispatch('close-modal', modal: 'bulk-action-modal');
            
        } catch (\Exception $e) {
            \Log::error('Bulk role removal error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error removing roles: ' . $e->getMessage(), type: 'error');
        }
    }

    public function save()
    {
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

        $existingUser = User::where('nik', trim($this->nik))
            ->when($this->user_id, function($query) {
                $query->where('id', '!=', $this->user_id);
            })
            ->first();

        if ($existingUser) {
            $this->addError('nik', 'NIK ini sudah terdaftar.');
            return;
        }

        $this->validate();

        try {
            if ($this->user_id) {
                $user = User::findOrFail($this->user_id);
                
                $data = [
                    'nik' => trim($this->nik),
                    'name' => trim($this->name),
                    'email' => $this->email ? trim($this->email) : null,
                ];

                if ($this->password) {
                    $data['password'] = Hash::make($this->password);
                }

                $user->update($data);
                $user->syncRoles($this->selectedRoles ?? []);
                
                $message = 'User berhasil diupdate!';
                $type = 'success';
            } else {
                $user = User::create([
                    'nik' => trim($this->nik),
                    'name' => trim($this->name),
                    'email' => $this->email ? trim($this->email) : null,
                    'password' => Hash::make($this->password),
                ]);
                
                if (!empty($this->selectedRoles)) {
                    $user->assignRole($this->selectedRoles);
                }
                
                $message = 'User berhasil dibuat!';
                $type = 'success';
            }

            $this->resetForm();
            $this->resetBulkSelection();
            $this->dispatch('notify', message: $message, type: $type);
            
        } catch (\Exception $e) {
            \Log::error('User save error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Terjadi kesalahan: ' . $e->getMessage(), type: 'error');
        }
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit users')) {
            $this->dispatch('notify', message: 'You do not have permission to edit users!', type: 'error');
            return;
        }

        $user = User::with('roles')->findOrFail($id);

        $this->user_id = $user->id;
        $this->nik = $user->nik;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->modalTitle = 'Edit User';
        $this->resetValidation();
        
        $this->dispatch('open-modal', modal: 'user-form-modal');
    }

    public function confirmDelete($id)
    {
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
        $this->dispatch('open-modal', modal: 'delete-user-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete users')) {
            $this->dispatch('notify', message: 'You do not have permission to delete users!', type: 'error');
            return;
        }

        try {
            $user = User::findOrFail($this->userToDelete->id);
            $userName = $user->name;
            $user->delete();

            $this->userToDelete = null;
            $this->resetBulkSelection();
            
            $this->dispatch('notify', message: "User '{$userName}' has been deleted successfully!", type: 'success');
            $this->dispatch('close-modal', modal: 'delete-user-modal');
            
        } catch (\Exception $e) {
            \Log::error('User delete error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Terjadi kesalahan saat menghapus user!', type: 'error');
        }
    }

    public function cancelDelete()
    {
        $this->userToDelete = null;
        $this->dispatch('close-modal', modal: 'delete-user-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view users')) {
            abort(403, 'Unauthorized access.');
        }
    
        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('nik', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm);
                });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10);
    
        $roles = Role::orderBy('created_at', 'asc')->get();
    
        return view('livewire.user.user-management', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}