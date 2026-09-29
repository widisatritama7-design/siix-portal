<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Deffect;
use App\Models\QAQC\BlindTest\Model;
use App\Models\QAQC\BlindTest\Question;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionManagement extends Component
{
    use WithPagination;

    public const MAX_DEFECTS = 5;

    public $question_id;
    public $customer_id = '';
    public $section = '';
    public $question_text = '';

    /**
     * Struktur:
     * [
     *   [
     *     'model_id'   => 1,
     *     'model_name' => 'X100',
     *     'items'      => [
     *         ['deffect_id' => 1, 'deffect_name' => 'Baret', 'location' => 'A1'],
     *         ...
     *     ]
     *   ],
     *   ...
     * ]
     */
    public $modelGroups = [];

    // Temp input
    public $selectedModelId = '';   // model yg dipilih untuk tambah defect
    public $tempDeffectId = '';
    public $tempLocation = '';

    public $search = '';
    public $filterSection = '';
    public $modalTitle = 'Add New Question';
    public $questionToDelete = null;

    public $viewData = null;
    public $activeTab = 'all';

    public const SECTIONS = ['QC', 'SMT', 'BE', 'MI'];

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:tb_qaqc_customer,id',
            'section'     => 'required|in:QC,SMT,BE,MI',
            'modelGroups' => 'required|array|min:1',
            'modelGroups.*.model_id' => 'required|exists:tb_qaqc_model,id',
            'modelGroups.*.items'    => 'required|array|min:1',
            'modelGroups.*.items.*.deffect_id' => 'required|exists:tb_qaqc_deffect,id',
            'modelGroups.*.items.*.location'   => 'required|string|max:255',
            'question_text' => 'nullable|string|max:1000',
        ];
    }

    protected $messages = [
        'customer_id.required'            => 'Customer is required.',
        'section.required'                => 'Section is required.',
        'modelGroups.required'            => 'Please add at least 1 model.',
        'modelGroups.min'                 => 'Please add at least 1 model.',
        'modelGroups.*.model_id.required' => 'Model is required.',
        'modelGroups.*.items.required'    => 'Each model must have at least 1 defect item.',
        'modelGroups.*.items.min'         => 'Each model must have at least 1 defect item.',
    ];

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterSection() { $this->resetPage(); }

    public function updatedCustomerId()
    {
        $this->modelGroups = [];
        $this->selectedModelId = '';
        $this->resetTemp();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset([
            'question_id',
            'customer_id',
            'section',
            'question_text',
            'modelGroups',
            'selectedModelId',
            'tempDeffectId',
            'tempLocation',
        ]);
        $this->modalTitle = 'Add New Question';
        $this->resetValidation();
    }

    private function resetTemp()
    {
        $this->tempDeffectId = '';
        $this->tempLocation = '';
    }

    /* ================= HELPERS ================= */

    public function getTotalDefectsProperty(): int
    {
        return collect($this->modelGroups)
            ->sum(fn($g) => count($g['items'] ?? []));
    }

    public function getRemainingQuotaProperty(): int
    {
        return max(0, self::MAX_DEFECTS - $this->totalDefects);
    }

    private function findGroupIndex($modelId): ?int
    {
        foreach ($this->modelGroups as $i => $g) {
            if ((int) $g['model_id'] === (int) $modelId) return $i;
        }
        return null;
    }

    /* ================= MODEL ================= */

    public function addModel()
    {
        $this->validate([
            'selectedModelId' => 'required|exists:tb_qaqc_model,id',
        ], [
            'selectedModelId.required' => 'Please select a model.',
        ]);

        $model = Model::find($this->selectedModelId);

        if (!$model || $model->customer_id != $this->customer_id) {
            $this->dispatch('notify', message: 'Selected model does not belong to selected customer!', type: 'error');
            return;
        }

        if ($this->findGroupIndex($this->selectedModelId) !== null) {
            $this->dispatch('notify', message: 'Model already added!', type: 'warning');
            $this->selectedModelId = '';
            return;
        }

        $this->modelGroups[] = [
            'model_id'   => $model->id,
            'model_name' => $model->model_name,
            'items'      => [],
        ];

        $this->selectedModelId = '';
        $this->dispatch('notify', message: 'Model added. Now add defect items.', type: 'success');
    }

    public function removeModel($index)
    {
        unset($this->modelGroups[$index]);
        $this->modelGroups = array_values($this->modelGroups);
    }

    /* ================= DEFECT ITEM ================= */

    public function addItem()
    {
        if ($this->totalDefects >= self::MAX_DEFECTS) {
            $this->dispatch('notify',
                message: 'Maximum ' . self::MAX_DEFECTS . ' defects per question already reached!',
                type: 'error');
            return;
        }

        $this->validate([
            'selectedModelId' => 'required|exists:tb_qaqc_model,id',
            'tempDeffectId'   => 'required|exists:tb_qaqc_deffect,id',
            'tempLocation'    => 'required|string|max:255',
        ], [
            'selectedModelId.required' => 'Please select a model first.',
            'tempDeffectId.required'   => 'Please select a defect item.',
            'tempLocation.required'    => 'Please enter a location.',
        ]);

        $idx = $this->findGroupIndex($this->selectedModelId);
        if ($idx === null) {
            $this->dispatch('notify', message: 'Model not found in list!', type: 'error');
            return;
        }

        $deffect  = Deffect::find($this->tempDeffectId);
        $location = strtoupper(trim($this->tempLocation));

        // Cek duplikat pair dalam model yang sama
        foreach ($this->modelGroups[$idx]['items'] as $item) {
            if ($item['deffect_id'] == $this->tempDeffectId && $item['location'] === $location) {
                $this->dispatch('notify',
                    message: 'This defect item + location already exists for this model!',
                    type: 'warning');
                $this->resetTemp();
                return;
            }
        }

        $this->modelGroups[$idx]['items'][] = [
            'deffect_id'   => $deffect->id,
            'deffect_name' => $deffect->deffect_item_name,
            'location'     => $location,
        ];

        $this->resetTemp();
        $this->resetValidation(['tempDeffectId', 'tempLocation', 'selectedModelId']);

        if ($this->totalDefects >= self::MAX_DEFECTS) {
            $this->dispatch('notify',
                message: 'Maximum ' . self::MAX_DEFECTS . ' defects reached.',
                type: 'warning');
        }
    }

    public function removeItem($modelIndex, $itemIndex)
    {
        if (!isset($this->modelGroups[$modelIndex]['items'][$itemIndex])) return;
        unset($this->modelGroups[$modelIndex]['items'][$itemIndex]);
        $this->modelGroups[$modelIndex]['items'] = array_values($this->modelGroups[$modelIndex]['items']);
    }

    /* ================= SAVE ================= */

    public function save()
    {
        if ($this->question_id) {
            if (!auth()->user()->can('edit question')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create question')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        if ($this->totalDefects > self::MAX_DEFECTS) {
            $this->dispatch('notify',
                message: 'Total defects cannot exceed ' . self::MAX_DEFECTS . ' pcs!',
                type: 'error');
            return;
        }

        $this->validate();

        // Pastikan semua model milik customer terpilih
        foreach ($this->modelGroups as $g) {
            $model = Model::find($g['model_id']);
            if (!$model || $model->customer_id != $this->customer_id) {
                $this->dispatch('notify',
                    message: 'One of selected models does not belong to selected customer!',
                    type: 'error');
                return;
            }
        }

        $primaryModelId = $this->modelGroups[0]['model_id'] ?? null;

        $items = collect($this->modelGroups)->map(fn($g) => [
            'model_id'   => $g['model_id'],
            'model_name' => $g['model_name'],
            'items'      => array_values($g['items']),
        ])->values()->all();

        $payload = [
            'customer_id'   => $this->customer_id,
            'model_id'      => $primaryModelId,
            'section'       => $this->section,
            'items'         => $items,
            'question_text' => $this->question_text,
            'updated_by'    => auth()->id(),
        ];

        $modelIds = collect($this->modelGroups)->pluck('model_id')->all();

        if ($this->question_id) {
            $question = Question::find($this->question_id);
            if (!$question) {
                $this->dispatch('notify', message: 'Question not found!', type: 'error');
                return;
            }
            $question->update($payload);
            $question->models()->sync($modelIds);
            $message = 'Question updated successfully!';
        } else {
            $payload['created_by'] = auth()->id();
            $question = Question::create($payload);
            $question->models()->sync($modelIds);
            $message = 'Question created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal-question');
    }

    /* ================= EDIT ================= */

    public function edit($id)
    {
        if (!auth()->user()->can('edit question')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $question = Question::with(['models', 'blindTests'])->find($id);
        if (!$question) {
            $this->dispatch('notify', message: 'Question not found!', type: 'error');
            return;
        }

        if ($question->isUsed()) {
            $count = $question->usageCount();
            $this->dispatch('notify',
                message: "Question ini sudah dipakai di {$count} blind test, tidak bisa diedit!",
                type: 'error');
            return;
        }

        $this->question_id   = $question->id;
        $this->customer_id   = $question->customer_id;
        $this->section       = $question->section;
        $this->question_text = $question->question_text;

        $rawItems = $question->items ?? [];
        $groups = [];

        // Deteksi format baru (tiap group punya model_id)
        $isNewFormat = !empty($rawItems) && isset($rawItems[0]['model_id']);

        if ($isNewFormat) {
            foreach ($rawItems as $g) {
                $groups[] = [
                    'model_id'   => $g['model_id'],
                    'model_name' => $g['model_name']
                        ?? (Model::find($g['model_id'])->model_name ?? '-'),
                    'items'      => array_values($g['items'] ?? []),
                ];
            }
        } else {
            // Format lama: items = [ ['deffect_id','deffect_name','location'], ... ]
            if (!empty($rawItems)) {
                $groups[] = [
                    'model_id'   => $question->model_id,
                    'model_name' => $question->model->model_name ?? '-',
                    'items'      => array_values($rawItems),
                ];
            }
        }

        $this->modelGroups     = $groups;
        $this->modalTitle      = 'Edit Question';
        $this->selectedModelId = '';
        $this->resetTemp();
        $this->dispatch('open-modal-question');
    }

    /* ================= VIEW ================= */

    public function view($id)
    {
        $question = Question::with(['customer', 'model', 'models', 'creator', 'updater'])->find($id);
        if (!$question) {
            $this->dispatch('notify', message: 'Question not found!', type: 'error');
            return;
        }
        $this->viewData = $question;
        $this->dispatch('open-modal-view');
    }

    /* ================= DELETE ================= */

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete question')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $question = Question::with('blindTests')->find($id);
        if (!$question) {
            $this->dispatch('notify', message: 'Question not found!', type: 'error');
            return;
        }

        if ($question->isUsed()) {
            $count = $question->usageCount();
            $this->dispatch('notify',
                message: "Question ini sudah dipakai di {$count} blind test, tidak bisa dihapus!",
                type: 'error');
            return;
        }

        $this->questionToDelete = $question;
        $this->dispatch('open-modal-delete');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete question')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $question = Question::find($this->questionToDelete->id);
        if (!$question) {
            $this->dispatch('notify', message: 'Question not found!', type: 'error');
            $this->questionToDelete = null;
            return;
        }

        if ($question->isUsed()) {
            $count = $question->usageCount();
            $this->dispatch('notify',
                message: "Question ini sudah dipakai di {$count} blind test, tidak bisa dihapus!",
                type: 'error');
            $this->questionToDelete = null;
            $this->dispatch('close-modal-delete');
            return;
        }

        $question->models()->detach();
        $question->delete();
        $this->questionToDelete = null;
        $this->dispatch('notify', message: 'Question deleted successfully!');
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete()
    {
        $this->questionToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    /* ================= RENDER ================= */

    public function render()
    {
        if (!auth()->user()->can('view question')) {
            abort(403, 'Unauthorized access.');
        }

        $query = Question::with(['customer', 'model', 'models', 'creator', 'updater']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('customer', fn($cq) =>
                        $cq->where('customer_name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('model', fn($mq) =>
                        $mq->where('model_name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('models', fn($mq) =>
                        $mq->where('model_name', 'like', '%' . $this->search . '%'));
            });
        }

        if ($this->filterSection) {
            $query->where('section', $this->filterSection);
        }

        $questions = $query->orderByDesc('id')->paginate(10);

        $models = $this->customer_id
            ? Model::where('customer_id', $this->customer_id)->orderBy('model_name')->get()
            : collect();

        return view('livewire.qaqc.blind-test.question-management', [
            'questions'  => $questions,
            'customers'  => Customer::orderBy('customer_name')->get(),
            'models'     => $models,
            'deffects'   => Deffect::orderBy('deffect_item_name')->get(),
            'sections'   => self::SECTIONS,
            'maxDefects' => self::MAX_DEFECTS,
        ]);
    }
}