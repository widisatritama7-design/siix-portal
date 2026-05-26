<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use App\Models\PROD\Uniform\UniformRequest;
use App\Models\HR\Employee;
use App\Models\PROD\Uniform\MasterUniform;

class UniformRequestShow extends Component
{
    public $request;
    public $requestId;
    public $selectedRowIndex = null;
    public $selectedFeedbackType = null;
    public $feedback_input = '';
    public $modalTitle = '';
    public $showModal = false; // Tambahkan properti untuk modal

    public function mount($id)
    {
        $this->requestId = $id;
        $this->request = UniformRequest::with('creator')->find($id);
        
        if (!$this->request) {
            session()->flash('error', 'Request not found!');
            return redirect()->route('prod.uniform.request.index');
        }
    }

    public function getItemsDetailProperty()
    {
        $items = $this->request->items ?? [];
        $details = [];
        
        foreach ($items as $index => $item) {
            $employee = Employee::find($item['employee_id']);
            $uniform = MasterUniform::find($item['master_uniform_id']);
            
            $details[] = [
                'index' => $index,
                'employee_id' => $item['employee_id'],
                'employee_name' => $employee->name ?? '-',
                'employee_nik' => $employee->nik ?? '-',
                'employee_department' => $employee->department ?? '-',
                'master_uniform_id' => $item['master_uniform_id'],
                'item_code' => $uniform->item_code ?? '-',
                'description' => $uniform->description ?? '-',
                'size' => $uniform->size ?? '-',
                'qty' => $item['qty'],
                'reason' => $item['reason'],
                'group' => $item['group'],
                'request_date' => $item['request_date'],
                'remarks' => $item['remarks'],
                'admin_feedback' => $item['admin_feedback'] ?? null,
                'admin_feedback_datetime' => $item['admin_feedback_datetime'] ?? null,
                'costing_feedback' => $item['costing_feedback'] ?? null,
                'costing_feedback_datetime' => $item['costing_feedback_datetime'] ?? null,
            ];
        }
        
        return $details;
    }

    public function openAdminFeedbackModal($rowIndex)
    {
        // Check permission for admin feedback
        if (!auth()->user()->can('feedback uniform request admin')) {
            session()->flash('error', 'You do not have permission to add admin feedback!');
            return;
        }

        $this->selectedRowIndex = $rowIndex;
        $this->selectedFeedbackType = 'admin';
        $this->feedback_input = '';
        $this->modalTitle = 'Add Admin Feedback';
        $this->showModal = true;
    }

    public function openCostingFeedbackModal($rowIndex)
    {
        // Check permission for costing feedback
        if (!auth()->user()->can('feedback uniform request costing')) {
            session()->flash('error', 'You do not have permission to add costing feedback!');
            return;
        }

        $this->selectedRowIndex = $rowIndex;
        $this->selectedFeedbackType = 'costing';
        $this->feedback_input = '';
        $this->modalTitle = 'Add Costing Feedback';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedRowIndex = null;
        $this->selectedFeedbackType = null;
        $this->feedback_input = '';
    }

    public function saveFeedback()
    {
        if (!$this->feedback_input || $this->selectedRowIndex === null) {
            session()->flash('error', 'Please enter feedback!');
            return;
        }
        
        $items = $this->request->items;
        
        if (isset($items[$this->selectedRowIndex])) {
            if ($this->selectedFeedbackType === 'admin') {
                $items[$this->selectedRowIndex]['admin_feedback'] = $this->feedback_input;
                $items[$this->selectedRowIndex]['admin_feedback_datetime'] = now()->toDateTimeString();
                $message = 'Admin feedback added successfully!';
            } else {
                $items[$this->selectedRowIndex]['costing_feedback'] = $this->feedback_input;
                $items[$this->selectedRowIndex]['costing_feedback_datetime'] = now()->toDateTimeString();
                $message = 'Costing feedback added successfully!';
            }
            
            $this->request->update(['items' => $items]);
            session()->flash('success', $message);
        }
        
        $this->closeModal();
        $this->request = UniformRequest::with('creator')->find($this->requestId);
    }

    public function render()
    {
        return view('livewire.prod.uniform.uniform-request-show', [
            'itemsDetail' => $this->items_detail,
        ]);
    }
}