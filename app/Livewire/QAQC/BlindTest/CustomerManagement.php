<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerManagement extends Component
{
    use WithPagination;

    public $customer_id;
    public $customer_name = '';
    public $search = '';
    public $modalTitle = 'Add New Customer';
    public $customerToDelete = null;

    // View
    public $viewData = null;

    // Tab
    public $activeTab = 'all';

    protected function rules()
    {
        return [
            'customer_name' => 'required|string|max:255|unique:tb_qaqc_customer,customer_name,' . ($this->customer_id ?? 'NULL') . ',id',
        ];
    }

    protected $messages = [
        'customer_name.required' => 'Customer name is required.',
        'customer_name.unique' => 'Customer name already exists.',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['customer_id', 'customer_name']);
        $this->modalTitle = 'Add New Customer';
        $this->resetValidation();
    }

    public function save()
    {
        if ($this->customer_id) {
            if (!auth()->user()->can('edit customer')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create customer')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        if ($this->customer_id) {
            $customer = Customer::find($this->customer_id);
            if (!$customer) {
                $this->dispatch('notify', message: 'Customer not found!', type: 'error');
                return;
            }

            $customer->update([
                'customer_name' => strtoupper($this->customer_name),
                'updated_by' => auth()->id(),
            ]);

            $message = 'Customer updated successfully!';
        } else {
            Customer::create([
                'customer_name' => strtoupper($this->customer_name),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            $message = 'Customer created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal-customer');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit customer')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $customer = Customer::find($id);
        if (!$customer) {
            $this->dispatch('notify', message: 'Customer not found!', type: 'error');
            return;
        }

        $this->customer_id = $customer->id;
        $this->customer_name = $customer->customer_name;
        $this->modalTitle = 'Edit Customer';
        $this->dispatch('open-modal-customer');
    }

    public function view($id)
    {
        $customer = Customer::with(['creator', 'updater'])->find($id);
        if (!$customer) {
            $this->dispatch('notify', message: 'Customer not found!', type: 'error');
            return;
        }

        $this->viewData = $customer;
        $this->dispatch('open-modal-view');
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete customer')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $customer = Customer::find($id);
        if (!$customer) {
            $this->dispatch('notify', message: 'Customer not found!', type: 'error');
            return;
        }

        $this->customerToDelete = $customer;
        $this->dispatch('open-modal-delete');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete customer')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $customer = Customer::find($this->customerToDelete->id);
        if (!$customer) {
            $this->dispatch('notify', message: 'Customer not found!', type: 'error');
            $this->customerToDelete = null;
            return;
        }

        $name = $customer->customer_name;
        $customer->delete();

        $this->customerToDelete = null;
        $this->dispatch('notify', message: "Customer '{$name}' has been deleted successfully!");
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete()
    {
        $this->customerToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    public function render()
    {
        if (!auth()->user()->can('view customer')) {
            abort(403, 'Unauthorized access.');
        }

        $query = Customer::with(['creator', 'updater']);

        if ($this->search) {
            $query->where('customer_name', 'like', '%' . $this->search . '%');
        }

        $customers = $query->orderByDesc('id')->paginate(10);

        return view('livewire.qaqc.blind-test.customer-management', [
            'customers' => $customers,
        ]);
    }
}