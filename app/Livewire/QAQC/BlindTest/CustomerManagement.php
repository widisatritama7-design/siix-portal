<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\Customer;
use Illuminate\Support\Facades\DB;
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

    // ==================== HELPER: CEK CUSTOMER DIPAKAI ====================

    /**
     * Ambil semua customer_id yang sudah dipakai (single query).
     * Sumber:
     *  1. tb_qaqc_model.customer_id
     *  2. tb_qaqc_question.customer_id
     *  3. tb_qaqc_blind_test.customer_id
     */
    protected function getUsedCustomerIds(): array
    {
        $used = [];

        // 1. Dari Model
        $modelUsed = DB::table('tb_qaqc_model')
            ->whereNotNull('customer_id')
            ->pluck('customer_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();
        $used = array_merge($used, $modelUsed);

        // 2. Dari Question
        $questionUsed = DB::table('tb_qaqc_question')
            ->whereNotNull('customer_id')
            ->pluck('customer_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();
        $used = array_merge($used, $questionUsed);

        // 3. Dari Blind Test
        $blindTestUsed = DB::table('tb_qaqc_blind_test')
            ->whereNotNull('customer_id')
            ->pluck('customer_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();
        $used = array_merge($used, $blindTestUsed);

        return array_values(array_unique($used));
    }

    /**
     * Cek single customer dipakai atau tidak.
     */
    public function isUsedInBlindTest(int $customerId): bool
    {
        return in_array($customerId, $this->getUsedCustomerIds(), true);
    }

    // ==================== SAVE ====================

    public function save()
    {
        if ($this->customer_id) {
            if (!auth()->user()->can('edit customer')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }

            // Cek kalau customer sudah dipakai → tidak bisa edit
            if ($this->isUsedInBlindTest((int) $this->customer_id)) {
                $this->dispatch('notify', message: 'Customer sudah dipakai di Model / Question / Blind Test, tidak bisa diedit!', type: 'error');
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

    // ==================== EDIT ====================

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

        // Cek kalau customer sudah dipakai → tidak bisa edit
        if ($this->isUsedInBlindTest((int) $customer->id)) {
            $this->dispatch(
                'notify',
                message: "Customer '{$customer->customer_name}' sudah dipakai, tidak bisa diedit!",
                type: 'error'
            );
            return;
        }

        $this->customer_id = $customer->id;
        $this->customer_name = $customer->customer_name;
        $this->modalTitle = 'Edit Customer';
        $this->dispatch('open-modal-customer');
    }

    // ==================== VIEW ====================

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

    // ==================== DELETE ====================

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

        // Cek kalau customer sudah dipakai → tidak bisa delete
        if ($this->isUsedInBlindTest((int) $customer->id)) {
            $this->dispatch(
                'notify',
                message: "Customer '{$customer->customer_name}' sudah dipakai, tidak bisa dihapus!",
                type: 'error'
            );
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

        if (!$this->customerToDelete) {
            $this->dispatch('close-modal-delete');
            return;
        }

        $customer = Customer::find($this->customerToDelete->id);
        if (!$customer) {
            $this->dispatch('notify', message: 'Customer not found!', type: 'error');
            $this->customerToDelete = null;
            $this->dispatch('close-modal-delete');
            return;
        }

        // Double protection
        if ($this->isUsedInBlindTest((int) $customer->id)) {
            $this->dispatch(
                'notify',
                message: "Customer '{$customer->customer_name}' sudah dipakai, tidak bisa dihapus!",
                type: 'error'
            );
            $this->customerToDelete = null;
            $this->dispatch('close-modal-delete');
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

    // ==================== RENDER ====================

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

        // Ambil semua customer_id yang sudah dipakai (single query)
        $usedIds = $this->getUsedCustomerIds();

        return view('livewire.qaqc.blind-test.customer-management', [
            'customers' => $customers,
            'usedIds'   => $usedIds,
        ]);
    }
}