<?php

namespace App\Livewire\ESD\Magazine;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Magazine\Magazine;

class MagazineManagement extends Component
{
    use WithPagination;

    public $magazine_id;
    public $register_no;
    public $status = 'In Use';

    public $search = '';
    public $modalTitle = 'Add New Magazine';
    public $magazineToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|unique:tb_esd_magazines,register_no,' . ($this->magazine_id ?? 'NULL'),
            'status' => 'required|in:In Use,Not In Use,Under Repair,Damage,Disposed',
        ];
    }

    protected $messages = [
        'register_no.required' => 'Register number is required.',
        'register_no.min' => 'Register number must be at least 3 characters.',
        'register_no.unique' => 'Register number already exists.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: Active, Inactive, Under Maintenance, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset(['magazine_id', 'register_no', 'status']);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Magazine';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->magazine_id) {
            if (!auth()->user()->can('edit magazine')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create magazine')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'register_no' => $this->register_no,
            'status' => $this->status,
        ];

        if ($this->magazine_id) {
            $magazine = Magazine::find($this->magazine_id);
            if (!$magazine) {
                $this->dispatch('notify', message: 'Magazine not found!', type: 'error');
                return;
            }

            $magazine->update($data);
            $message = 'Magazine updated successfully!';
        } else {
            Magazine::create($data);
            $message = 'Magazine created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'magazine-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit magazine')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $magazine = Magazine::find($id);

        if (!$magazine) {
            $this->dispatch('notify', message: 'Magazine not found!', type: 'error');
            return;
        }

        $this->magazine_id = $magazine->id;
        $this->register_no = $magazine->register_no;
        $this->status = $magazine->status;
        $this->modalTitle = 'Edit Magazine';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete magazine')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $magazine = Magazine::find($id);

        if (!$magazine) {
            $this->dispatch('notify', message: 'Magazine not found!', type: 'error');
            return;
        }

        $this->magazineToDelete = $magazine;
        $this->dispatch('open-modal', 'delete-magazine-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete magazine')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $magazine = Magazine::find($this->magazineToDelete->id);

        if (!$magazine) {
            $this->dispatch('notify', message: 'Magazine not found!', type: 'error');
            $this->magazineToDelete = null;
            return;
        }

        $registerNo = $magazine->register_no;
        $magazine->delete();

        $this->magazineToDelete = null;
        $this->dispatch('notify', message: "Magazine '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-magazine-modal');
    }

    public function cancelDelete()
    {
        $this->magazineToDelete = null;
        $this->dispatch('close-modal', 'delete-magazine-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view magazine')) {
            abort(403, 'Unauthorized access.');
        }

        $magazines = Magazine::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.esd.magazine.magazine-management', [
            'magazines' => $magazines,
        ]);
    }
}