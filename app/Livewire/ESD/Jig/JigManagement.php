<?php

namespace App\Livewire\ESD\Jig;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ESD\Jig\Jig;
use Carbon\Carbon;

class JigManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $jig_id;
    public $received_date;
    public $registration_date;
    public $register_no;
    public $sek_cust_id;
    public $fabricator;
    public $model;
    public $description;
    public $application;
    public $pin_qty;
    public $jig_qty;
    public $photo;
    public $design_by;
    public $qualified_date;
    public $results;
    public $remarks;
    public $bit_size;
    public $customer;
    public $tooling_type;
    public $category;
    public $location;
    public $status = 'Active';
    public $amount_solder;
    public $rack;
    public $nik;
    public $rack_number;
    public $line_name;
    public $count_stencil;

    public $search = '';
    public $modalTitle = 'Add New Jig';
    public $jigToDelete = null;
    public $existingPhoto = null;
    public $tempPhoto = null;

    protected function rules()
    {
        return [
            'received_date' => 'nullable|date',
            'registration_date' => 'nullable|date',
            'register_no' => 'required|min:3|unique:tb_esd_jigs,register_no,' . ($this->jig_id ?? 'NULL'),
            'sek_cust_id' => 'nullable|string',
            'fabricator' => 'nullable|string',
            'model' => 'nullable|string',
            'description' => 'nullable|string',
            'application' => 'nullable|string',
            'pin_qty' => 'nullable|integer|min:0',
            'jig_qty' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:2048', // 2MB max
            'design_by' => 'nullable|string',
            'qualified_date' => 'nullable|date',
            'results' => 'nullable|string',
            'remarks' => 'nullable|string',
            'bit_size' => 'nullable|string',
            'customer' => 'nullable|string',
            'tooling_type' => 'nullable|string',
            'category' => 'nullable|string',
            'location' => 'nullable|string',
            'status' => 'required|in:Active,Inactive,Under Repair,Damage,Disposed',
            'amount_solder' => 'nullable|string',
            'rack' => 'nullable|string',
            'nik' => 'nullable|string',
            'rack_number' => 'nullable|string',
            'line_name' => 'nullable|string',
            'count_stencil' => 'nullable|string',
        ];
    }

    protected $messages = [
        'register_no.required' => 'Register number is required.',
        'register_no.min' => 'Register number must be at least 3 characters.',
        'register_no.unique' => 'Register number already exists.',
        'pin_qty.integer' => 'Pin quantity must be a number.',
        'pin_qty.min' => 'Pin quantity must be at least 0.',
        'jig_qty.integer' => 'Jig quantity must be a number.',
        'jig_qty.min' => 'Jig quantity must be at least 0.',
        'photo.image' => 'The file must be an image.',
        'photo.max' => 'The image size must not exceed 2MB.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: Active, Inactive, Under Repair, Damage, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset([
            'jig_id', 'received_date', 'registration_date', 'register_no', 'sek_cust_id',
            'fabricator', 'model', 'description', 'application', 'pin_qty', 'jig_qty',
            'photo', 'design_by', 'qualified_date', 'results', 'remarks', 'bit_size',
            'customer', 'tooling_type', 'category', 'location', 'status', 'amount_solder',
            'rack', 'nik', 'rack_number', 'line_name', 'count_stencil', 'existingPhoto', 'tempPhoto'
        ]);
        $this->status = 'Active';
        $this->modalTitle = 'Add New Jig';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->jig_id) {
            if (!auth()->user()->can('edit jig')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create jig')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'received_date' => $this->received_date,
            'registration_date' => $this->registration_date,
            'register_no' => $this->register_no,
            'sek_cust_id' => $this->sek_cust_id,
            'fabricator' => $this->fabricator,
            'model' => $this->model,
            'description' => $this->description,
            'application' => $this->application,
            'pin_qty' => $this->pin_qty,
            'jig_qty' => $this->jig_qty,
            'design_by' => $this->design_by,
            'qualified_date' => $this->qualified_date,
            'results' => $this->results,
            'remarks' => $this->remarks,
            'bit_size' => $this->bit_size,
            'customer' => $this->customer,
            'tooling_type' => $this->tooling_type,
            'category' => $this->category,
            'location' => $this->location,
            'status' => $this->status,
            'amount_solder' => $this->amount_solder,
            'rack' => $this->rack,
            'nik' => $this->nik,
            'rack_number' => $this->rack_number,
            'line_name' => $this->line_name,
            'count_stencil' => $this->count_stencil,
        ];

        // Handle photo upload
        if ($this->photo) {
            $path = $this->photo->store('jig-photos', 'public');
            $data['photo'] = [$path]; // Store as array
        } elseif ($this->existingPhoto) {
            $data['photo'] = $this->existingPhoto;
        }

        if ($this->jig_id) {
            $jig = Jig::find($this->jig_id);
            if (!$jig) {
                $this->dispatch('notify', message: 'Jig not found!', type: 'error');
                return;
            }

            $jig->update($data);
            $message = 'Jig updated successfully!';
        } else {
            Jig::create($data);
            $message = 'Jig created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'jig-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit jig')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $jig = Jig::find($id);

        if (!$jig) {
            $this->dispatch('notify', message: 'Jig not found!', type: 'error');
            return;
        }

        $this->jig_id = $jig->id;
        $this->received_date = $jig->received_date ? Carbon::parse($jig->received_date)->format('Y-m-d') : null;
        $this->registration_date = $jig->registration_date ? Carbon::parse($jig->registration_date)->format('Y-m-d') : null;
        $this->register_no = $jig->register_no;
        $this->sek_cust_id = $jig->sek_cust_id;
        $this->fabricator = $jig->fabricator;
        $this->model = $jig->model;
        $this->description = $jig->description;
        $this->application = $jig->application;
        $this->pin_qty = $jig->pin_qty;
        $this->jig_qty = $jig->jig_qty;
        $this->existingPhoto = $jig->photo;
        $this->design_by = $jig->design_by;
        $this->qualified_date = $jig->qualified_date ? Carbon::parse($jig->qualified_date)->format('Y-m-d') : null;
        $this->results = $jig->results;
        $this->remarks = $jig->remarks;
        $this->bit_size = $jig->bit_size;
        $this->customer = $jig->customer;
        $this->tooling_type = $jig->tooling_type;
        $this->category = $jig->category;
        $this->location = $jig->location;
        $this->status = $jig->status;
        $this->amount_solder = $jig->amount_solder;
        $this->rack = $jig->rack;
        $this->nik = $jig->nik;
        $this->rack_number = $jig->rack_number;
        $this->line_name = $jig->line_name;
        $this->count_stencil = $jig->count_stencil;
        $this->modalTitle = 'Edit Jig';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete jig')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $jig = Jig::find($id);

        if (!$jig) {
            $this->dispatch('notify', message: 'Jig not found!', type: 'error');
            return;
        }

        $this->jigToDelete = $jig;
        $this->dispatch('open-modal', 'delete-jig-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete jig')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $jig = Jig::find($this->jigToDelete->id);

        if (!$jig) {
            $this->dispatch('notify', message: 'Jig not found!', type: 'error');
            $this->jigToDelete = null;
            return;
        }

        $registerNo = $jig->register_no;
        $jig->delete();

        $this->jigToDelete = null;
        $this->dispatch('notify', message: "Jig '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-jig-modal');
    }

    public function cancelDelete()
    {
        $this->jigToDelete = null;
        $this->dispatch('close-modal', 'delete-jig-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view jig')) {
            abort(403, 'Unauthorized access.');
        }

        $jigs = Jig::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('model', 'like', '%' . $this->search . '%')
                    ->orWhere('customer', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.esd.jig.jig-management', [
            'jigs' => $jigs,
        ]);
    }
}