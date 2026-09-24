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

    public $question_id;
    public $customer_id = '';
    public $model_id = '';
    public $section = '';
    public $question_text = '';

    // Array pasangan: [ ['deffect_id' => 1, 'deffect_name' => 'X', 'location' => 'A1'], ... ]
    public $items = [];

    // Temp input untuk menambah pair baru
    public $tempDeffectId = '';
    public $tempLocation = '';

    public $search = '';
    public $filterSection = '';
    public $modalTitle = 'Add New Question';
    public $questionToDelete = null;

    // View
    public $viewData = null;

    // Tab
    public $activeTab = 'all';

    public const SECTIONS = ['QC', 'SMT', 'BE', 'MI'];

    protected function rules()
    {
        return [
            'customer_id'   => 'required|exists:tb_qaqc_customer,id',
            'model_id'      => 'required|exists:tb_qaqc_model,id',
            'section'       => 'required|in:QC,SMT,BE,MI',
            'items'         => 'required|array|min:1',
            'items.*.deffect_id' => 'required|exists:tb_qaqc_deffect,id',
            'items.*.location'   => 'required|string|max:255',
            'question_text' => 'nullable|string|max:1000',
        ];
    }

    protected $messages = [
        'customer_id.required'  => 'Customer is required.',
        'model_id.required'     => 'Model is required.',
        'section.required'      => 'Section is required.',
        'items.required'        => 'Please add at least 1 defect item with location.',
        'items.min'             => 'Please add at least 1 defect item with location.',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterSection()
    {
        $this->resetPage();
    }

    public function updatedCustomerId()
    {
        $this->model_id = '';
        $this->items = [];
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
            'model_id',
            'section',
            'question_text',
            'items',
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

    /* ================= ITEM (PAIR) HANDLERS ================= */

    public function addItem()
    {
        $this->validate([
            'tempDeffectId' => 'required|exists:tb_qaqc_deffect,id',
            'tempLocation'  => 'required|string|max:255',
        ], [
            'tempDeffectId.required' => 'Please select a defect item.',
            'tempDeffectId.exists'   => 'Selected defect item is invalid.',
            'tempLocation.required'  => 'Please enter a location.',
        ]);

        $deffect = Deffect::find($this->tempDeffectId);
        $location = strtoupper(trim($this->tempLocation));

        // Cegah duplikat pair (deffect + location sama)
        foreach ($this->items as $item) {
            if ($item['deffect_id'] == $this->tempDeffectId && $item['location'] === $location) {
                $this->dispatch('notify', message: 'This defect item and location pair already exists!', type: 'warning');
                $this->resetTemp();
                return;
            }
        }

        $this->items[] = [
            'deffect_id'   => $deffect->id,
            'deffect_name' => $deffect->deffect_item_name,
            'location'     => $location,
        ];

        $this->resetTemp();
        $this->resetValidation(['tempDeffectId', 'tempLocation']);
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
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

        $this->validate();

        // Validasi: model harus milik customer terpilih
        $model = Model::find($this->model_id);
        if (!$model || $model->customer_id != $this->customer_id) {
            $this->dispatch('notify', message: 'Selected model does not belong to selected customer!', type: 'error');
            return;
        }

        $payload = [
            'customer_id'   => $this->customer_id,
            'model_id'      => $this->model_id,
            'section'       => $this->section,
            'items'         => array_values($this->items),
            'question_text' => $this->question_text,
            'updated_by'    => auth()->id(),
        ];

        if ($this->question_id) {
            $question = Question::find($this->question_id);
            if (!$question) {
                $this->dispatch('notify', message: 'Question not found!', type: 'error');
                return;
            }
            $question->update($payload);
            $message = 'Question updated successfully!';
        } else {
            $payload['created_by'] = auth()->id();
            Question::create($payload);
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

        $question = Question::with('blindTests')->find($id);
        if (!$question) {
            $this->dispatch('notify', message: 'Question not found!', type: 'error');
            return;
        }

        // 🚫 Block kalau sudah dipakai
        if ($question->isUsed()) {
            $count = $question->usageCount();
            $this->dispatch('notify',
                message: "Question ini sudah dipakai di {$count} blind test, tidak bisa diedit!",
                type: 'error');
            return;
        }

        $this->question_id   = $question->id;
        $this->customer_id   = $question->customer_id;
        $this->model_id      = $question->model_id;
        $this->section       = $question->section;
        $this->items         = $question->items ?? [];
        $this->question_text = $question->question_text;
        $this->modalTitle    = 'Edit Question';
        $this->resetTemp();
        $this->dispatch('open-modal-question');
    }

    /* ================= VIEW ================= */

    public function view($id)
    {
        $question = Question::with(['customer', 'model', 'creator', 'updater'])->find($id);
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

        // 🚫 Block kalau sudah dipakai
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

        // 🚫 Double guard (safety net)
        if ($question->isUsed()) {
            $count = $question->usageCount();
            $this->dispatch('notify',
                message: "Question ini sudah dipakai di {$count} blind test, tidak bisa dihapus!",
                type: 'error');
            $this->questionToDelete = null;
            $this->dispatch('close-modal-delete');
            return;
        }

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

        $query = Question::with(['customer', 'model', 'creator', 'updater']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('customer', function ($cq) {
                    $cq->where('customer_name', 'like', '%' . $this->search . '%');
                })->orWhereHas('model', function ($mq) {
                    $mq->where('model_name', 'like', '%' . $this->search . '%');
                });
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
            'questions' => $questions,
            'customers' => Customer::orderBy('customer_name')->get(),
            'models'    => $models,
            'deffects'  => Deffect::orderBy('deffect_item_name')->get(),
            'sections'  => self::SECTIONS,
        ]);
    }
}