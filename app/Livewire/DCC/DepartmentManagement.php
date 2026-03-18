<?php

namespace App\Livewire\DCC;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DCC\Department;

class DepartmentManagement extends Component
{
    use WithPagination;

    public $department_id;
    public $dept_name;
    public $emails = [];
    public $email_input = '';

    public $search = '';
    public $modalTitle = 'Add New Department';
    public $departmentToDelete = null;

    protected function rules()
    {
        return [
            'dept_name' => 'required|min:3|unique:tb_dcc_departments,dept_name,' . $this->department_id,
            'emails' => 'nullable',
        ];
    }

    protected $messages = [
        'dept_name.required' => 'Department name is required.',
        'dept_name.min' => 'Department name must be at least 3 characters.',
        'dept_name.unique' => 'This department name already exists.',
    ];

    public function resetForm()
    {
        $this->reset(['department_id', 'dept_name', 'emails', 'email_input']);
        $this->modalTitle = 'Add New Department';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function addEmail()
    {
        if ($this->email_input && filter_var($this->email_input, FILTER_VALIDATE_EMAIL)) {
            $this->emails[] = $this->email_input;
            $this->email_input = '';
        } else {
            $this->dispatch('notify', message: 'Please enter a valid email!', type: 'error');
        }
    }

    public function removeEmail($index)
    {
        unset($this->emails[$index]);
        $this->emails = array_values($this->emails);
    }

    public function save()
    {
        if ($this->department_id) {
            if (!auth()->user()->can('edit departments')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create departments')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'dept_name' => $this->dept_name,
            'emails' => $this->emails,
        ];

        if ($this->department_id) {
            $department = Department::find($this->department_id);
            if (!$department) {
                $this->dispatch('notify', message: 'Department not found!', type: 'error');
                return;
            }

            $department->update($data);
            $message = 'Department updated successfully!';
        } else {
            Department::create($data);
            $message = 'Department created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'department-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit departments')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $department = Department::find($id);

        if (!$department) {
            $this->dispatch('notify', message: 'Department not found!', type: 'error');
            return;
        }

        $this->department_id = $department->id;
        $this->dept_name = $department->dept_name;
        $this->emails = $department->emails_list ?? [];
        $this->modalTitle = 'Edit Department';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete departments')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $department = Department::find($id);

        if (!$department) {
            $this->dispatch('notify', message: 'Department not found!', type: 'error');
            return;
        }

        if ($department->submissions()->count() > 0) {
            $this->dispatch('notify', message: 'Cannot delete department that has submissions!', type: 'error');
            return;
        }

        $this->departmentToDelete = $department;
        $this->dispatch('open-modal', 'delete-department-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete departments')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $department = Department::find($this->departmentToDelete->id);

        if (!$department) {
            $this->dispatch('notify', message: 'Department not found!', type: 'error');
            $this->departmentToDelete = null;
            return;
        }

        $deptName = $department->dept_name;
        $department->delete();

        $this->departmentToDelete = null;
        $this->dispatch('notify', message: "Department '{$deptName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-department-modal');
    }

    public function cancelDelete()
    {
        $this->departmentToDelete = null;
        $this->dispatch('close-modal', 'delete-department-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view departments')) {
            abort(403, 'Unauthorized access.');
        }

        $departments = Department::with('creator')
            ->when($this->search, function ($query) {
                $query->where('dept_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('dept_name')
            ->paginate(10);

        return view('livewire.dcc.department-management', [
            'departments' => $departments,
        ]);
    }
}