<?php

namespace App\Livewire\User\Permission;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionManagement extends Component
{
    use WithPagination;

    public $permission_id;
    public $name;
    public $selectedRoles = [];
    
    public $search = '';
    public $modalTitle = 'Add New Permission';
    public $permissionToDelete = null;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|unique:permissions,name,' . $this->permission_id,
        ];
    }

    protected $messages = [
        'name.required' => 'The permission name is required.',
        'name.min' => 'The permission name must be at least 3 characters.',
        'name.unique' => 'This permission name already exists.',
    ];

    public function resetForm()
    {
        $this->reset(['permission_id', 'name', 'selectedRoles']);
        $this->modalTitle = 'Add New Permission';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        // CEK AKSES
        if ($this->permission_id) {
            if (!auth()->user()->can('edit permissions')) {
                $this->dispatch('notify', message: 'You do not have permission to edit permissions!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create permissions')) {
                $this->dispatch('notify', message: 'You do not have permission to create permissions!', type: 'error');
                return;
            }
        }

        $this->validate();

        if ($this->permission_id) {
            $permission = Permission::find($this->permission_id);
            
            if (!$permission) {
                $this->dispatch('notify', message: 'Permission not found!', type: 'error');
                return;
            }
            
            $oldName = $permission->name;
            $permission->name = $this->name;
            $permission->save();

            if (!empty($this->selectedRoles)) {
                $permission->syncRoles($this->selectedRoles);
            }

            $message = "Permission '{$oldName}' updated to '{$this->name}' successfully!";
        } else {
            $permission = Permission::create(['name' => $this->name]);

            if (!empty($this->selectedRoles)) {
                $permission->assignRole($this->selectedRoles);
            }

            $message = "Permission '{$this->name}' created successfully!";
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
    }

    public function edit($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('edit permissions')) {
            $this->dispatch('notify', message: 'You do not have permission to edit permissions!', type: 'error');
            return;
        }

        $permission = Permission::with('roles')->find($id);
        
        if (!$permission) {
            $this->dispatch('notify', message: 'Permission not found!', type: 'error');
            return;
        }

        $this->permission_id = $permission->id;
        $this->name = $permission->name;
        $this->selectedRoles = $permission->roles->pluck('name')->toArray();
        $this->modalTitle = 'Edit Permission';
    }

    public function confirmDelete($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('delete permissions')) {
            $this->dispatch('notify', message: 'You do not have permission to delete permissions!', type: 'error');
            return;
        }

        $permission = Permission::find($id);
        
        if (!$permission) {
            $this->dispatch('notify', message: 'Permission not found!', type: 'error');
            return;
        }
        
        $this->permissionToDelete = $permission;
    }

    public function delete()
    {
        if (!auth()->user()->can('delete permissions')) {
            $this->dispatch('notify', message: 'You do not have permission to delete permissions!', type: 'error');
            return;
        }

        $permission = Permission::find($this->permissionToDelete->id);
        
        if (!$permission) {
            $this->dispatch('notify', message: 'Permission not found!', type: 'error');
            $this->permissionToDelete = null;
            return;
        }
        
        if ($permission->roles()->count() > 0) {
            $this->dispatch('notify', message: 'Cannot delete permission that is assigned to roles!', type: 'error');
            $this->permissionToDelete = null;
            return;
        }

        $permissionName = $permission->name;
        $permission->delete();

        $this->permissionToDelete = null;
        $this->dispatch('notify', message: "Permission '{$permissionName}' has been deleted successfully!");
    }

    public function cancelDelete()
    {
        $this->permissionToDelete = null;
    }

    public function render()
    {
        // CEK AKSES VIEW
        if (!auth()->user()->can('view permissions')) {
            abort(403, 'Unauthorized access.');
        }

        $permissions = Permission::with('roles')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        $roles = Role::orderBy('name')->get();

        return view('livewire.user.permission.permission-management', [
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }
}