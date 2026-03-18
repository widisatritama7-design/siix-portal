<?php

namespace App\Livewire\User\Role;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManagement extends Component
{
    use WithPagination;

    public $role_id;
    public $name;
    public $selectedPermissions = [];
    
    public $search = '';
    public $modalTitle = 'Add New Role';
    public $roleToDelete = null;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|unique:roles,name,' . $this->role_id,
        ];
    }

    protected $messages = [
        'name.required' => 'The role name is required.',
        'name.min' => 'The role name must be at least 3 characters.',
        'name.unique' => 'This role name already exists.',
    ];

    public function resetForm()
    {
        $this->reset(['role_id', 'name', 'selectedPermissions']);
        $this->modalTitle = 'Add New Role';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        // CEK AKSES
        if ($this->role_id) {
            if (!auth()->user()->can('edit roles')) {
                $this->dispatch('notify', message: 'You do not have permission to edit roles!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create roles')) {
                $this->dispatch('notify', message: 'You do not have permission to create roles!', type: 'error');
                return;
            }
        }

        $this->validate();

        if ($this->role_id) {
            $role = Role::find($this->role_id);
            if (!$role) {
                $this->dispatch('notify', message: 'Role not found!', type: 'error');
                return;
            }
            
            $role->name = $this->name;
            $role->save();
            $role->syncPermissions($this->selectedPermissions);

            $message = 'Role updated successfully!';
        } else {
            $role = Role::create(['name' => $this->name]);

            if (!empty($this->selectedPermissions)) {
                $role->syncPermissions($this->selectedPermissions);
            }

            $message = 'Role created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
    }

    public function edit($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('edit roles')) {
            $this->dispatch('notify', message: 'You do not have permission to edit roles!', type: 'error');
            return;
        }

        $role = Role::with('permissions')->find($id);
        
        if (!$role) {
            $this->dispatch('notify', message: 'Role not found!', type: 'error');
            return;
        }

        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->modalTitle = 'Edit Role';
    }

    public function confirmDelete($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('delete roles')) {
            $this->dispatch('notify', message: 'You do not have permission to delete roles!', type: 'error');
            return;
        }

        $role = Role::find($id);
        
        if (!$role) {
            $this->dispatch('notify', message: 'Role not found!', type: 'error');
            return;
        }
        
        $this->roleToDelete = $role;
    }

    public function delete()
    {
        if (!auth()->user()->can('delete roles')) {
            $this->dispatch('notify', message: 'You do not have permission to delete roles!', type: 'error');
            return;
        }

        $role = Role::find($this->roleToDelete->id);
        
        if (!$role) {
            $this->dispatch('notify', message: 'Role not found!', type: 'error');
            $this->roleToDelete = null;
            return;
        }
        
        if ($role->users()->count() > 0) {
            $this->dispatch('notify', message: 'Cannot delete role that is assigned to users!', type: 'error');
            $this->roleToDelete = null;
            return;
        }

        if ($role->name === 'super-admin') {
            $this->dispatch('notify', message: 'Cannot delete Super Admin role!', type: 'error');
            $this->roleToDelete = null;
            return;
        }

        $roleName = $role->name;
        $role->delete();

        $this->roleToDelete = null;
        $this->dispatch('notify', message: "Role '{$roleName}' has been deleted successfully!");
    }

    public function cancelDelete()
    {
        $this->roleToDelete = null;
    }

    public function render()
    {
        // CEK AKSES VIEW
        if (!auth()->user()->can('view roles')) {
            abort(403, 'Unauthorized access.');
        }

        $roles = Role::with('permissions', 'users')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        $permissions = Permission::orderBy('name')->get()->groupBy(function($item) {
            $words = explode(' ', $item->name);
            return $words[1] ?? 'other';
        });

        return view('livewire.user.role.role-management', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
}