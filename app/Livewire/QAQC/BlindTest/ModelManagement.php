<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ModelManagement extends Component
{
    use WithPagination;

    public $model_id;
    public $customer_id = '';
    public $model_name = '';
    public $search = '';
    public $modalTitle = 'Add New Model';
    public $modelToDelete = null;

    // View
    public $viewData = null;

    // Tab
    public $activeTab = 'all';

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:tb_qaqc_customer,id',
            'model_name'  => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('tb_qaqc_model', 'model_name')
                    ->where(fn ($q) => $q->where('customer_id', $this->customer_id))
                    ->ignore($this->model_id),
            ],
        ];
    }

    protected $messages = [
        'customer_id.required' => 'Customer is required.',
        'customer_id.exists'   => 'Selected customer is invalid.',
        'model_name.required'  => 'Model name is required.',
        'model_name.unique'    => 'Model name sudah dipakai untuk customer ini.',
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
        $this->reset(['model_id', 'customer_id', 'model_name']);
        $this->modalTitle = 'Add New Model';
        $this->resetValidation();
    }

    // ==================== HELPER: CEK MODEL DIPAKAI ====================

    /**
     * Ambil semua model_id yang sudah dipakai (single query).
     * Sumber:
     *  1. tb_qaqc_blind_test.question_snapshot (JSON: model_id per soal)
     *  2. tb_qaqc_blind_test.model_id (backward compat)
     *  3. tb_qaqc_question.model_id (master soal)
     */
    protected function getUsedModelIds(): array
    {
        $used = [];

        // ===== 1 & 2: Dari blind test =====
        $rows = DB::table('tb_qaqc_blind_test')
            ->select('question_snapshot', 'model_id')
            ->get();

        foreach ($rows as $row) {
            // Dari question_snapshot
            if ($row->question_snapshot) {
                $snapshots = json_decode($row->question_snapshot, true) ?? [];
                foreach ($snapshots as $snap) {
                    if (!empty($snap['model_id'])) {
                        $used[] = (int) $snap['model_id'];
                    }
                }
            }

            // Fallback: kolom model_id
            if (!empty($row->model_id)) {
                $used[] = (int) $row->model_id;
            }
        }

        // ===== 3: Dari master question =====
        $questionUsed = DB::table('tb_qaqc_question')
            ->whereNotNull('model_id')
            ->pluck('model_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        $used = array_merge($used, $questionUsed);

        return array_values(array_unique($used));
    }

    /**
     * Cek single model dipakai atau tidak.
     */
    public function isUsedInBlindTest(int $modelId): bool
    {
        return in_array($modelId, $this->getUsedModelIds(), true);
    }

    // ==================== SAVE ====================

    public function save()
    {
        if ($this->model_id) {
            if (!auth()->user()->can('edit model')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }

            // Cek kalau model sudah dipakai → tidak bisa edit
            if ($this->isUsedInBlindTest((int) $this->model_id)) {
                $this->dispatch('notify', message: 'Model sudah dipakai di Blind Test / Master Question, tidak bisa diedit!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create model')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        if ($this->model_id) {
            $model = Model::find($this->model_id);
            if (!$model) {
                $this->dispatch('notify', message: 'Model not found!', type: 'error');
                return;
            }

            $model->update([
                'customer_id' => $this->customer_id,
                'model_name' => strtoupper($this->model_name),
                'updated_by' => auth()->id(),
            ]);

            $message = 'Model updated successfully!';
        } else {
            Model::create([
                'customer_id' => $this->customer_id,
                'model_name' => strtoupper($this->model_name),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            $message = 'Model created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal-model');
    }

    // ==================== EDIT ====================

    public function edit($id)
    {
        if (!auth()->user()->can('edit model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $model = Model::find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        // Cek kalau model sudah dipakai → tidak bisa edit
        if ($this->isUsedInBlindTest((int) $model->id)) {
            $this->dispatch(
                'notify',
                message: "Model '{$model->model_name}' sudah dipakai di Blind Test / Master Question, tidak bisa diedit!",
                type: 'error'
            );
            return;
        }

        $this->model_id = $model->id;
        $this->customer_id = $model->customer_id;
        $this->model_name = $model->model_name;
        $this->modalTitle = 'Edit Model';
        $this->dispatch('open-modal-model');
    }

    // ==================== VIEW ====================

    public function view($id)
    {
        $model = Model::with(['customer', 'creator', 'updater'])->find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        $this->viewData = $model;
        $this->dispatch('open-modal-view');
    }

    // ==================== DELETE ====================

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $model = Model::find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        // Cek kalau model sudah dipakai → tidak bisa delete
        if ($this->isUsedInBlindTest((int) $model->id)) {
            $this->dispatch(
                'notify',
                message: "Model '{$model->model_name}' sudah dipakai di Blind Test / Master Question, tidak bisa dihapus!",
                type: 'error'
            );
            return;
        }

        $this->modelToDelete = $model;
        $this->dispatch('open-modal-delete');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (!$this->modelToDelete) {
            $this->dispatch('close-modal-delete');
            return;
        }

        $model = Model::find($this->modelToDelete->id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            $this->modelToDelete = null;
            $this->dispatch('close-modal-delete');
            return;
        }

        // Double protection
        if ($this->isUsedInBlindTest((int) $model->id)) {
            $this->dispatch(
                'notify',
                message: "Model '{$model->model_name}' sudah dipakai di Blind Test / Master Question, tidak bisa dihapus!",
                type: 'error'
            );
            $this->modelToDelete = null;
            $this->dispatch('close-modal-delete');
            return;
        }

        $name = $model->model_name;
        $model->delete();

        $this->modelToDelete = null;
        $this->dispatch('notify', message: "Model '{$name}' has been deleted successfully!");
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete()
    {
        $this->modelToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    // ==================== RENDER ====================

    public function render()
    {
        if (!auth()->user()->can('view model')) {
            abort(403, 'Unauthorized access.');
        }

        $query = Model::with(['customer', 'creator', 'updater']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('model_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($cq) {
                        $cq->where('customer_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $models = $query->orderByDesc('id')->paginate(10);

        // Ambil semua model_id yang sudah dipakai (single query)
        $usedIds = $this->getUsedModelIds();

        return view('livewire.qaqc.blind-test.model-management', [
            'models'    => $models,
            'customers' => Customer::orderBy('customer_name')->get(),
            'usedIds'   => $usedIds,
        ]);
    }
}