<?php

namespace App\Livewire\PROD\MS;

use App\Models\PROD\MS\DetailMasterSample;
use App\Models\PROD\MS\MasterSample;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MasterSampleExpiredForm extends Component
{
    public $masterSample;
    public $expiredId = null;
    public $updatedDate;
    public $expiredDate;
    public $alarmDate;
    public $checkedBy;
    public $knowledgeBy;
    public $approvedBy;
    public $isEdit = false;
    
    public $checkerOptions = [];
    public $knowledgeOptions = [];
    public $approverOptions = [];
    
    protected function rules()
    {
        return [
            'updatedDate' => 'required|date',
            'expiredDate' => 'required|date|after_or_equal:updatedDate',
            'alarmDate' => 'required|date',
        ];
    }
    
    public function mount($sampleId, $id = null)
    {
        $this->masterSample = MasterSample::findOrFail($sampleId);
        
        if (!auth()->user()->can('edit master sample')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadUserOptions();
        
        if ($id) {
            $this->isEdit = true;
            $this->expiredId = $id;
            $this->loadExpiredData();
        } else {
            $this->resetForm();
        }
    }
    
    private function loadUserOptions()
    {
        $this->checkerOptions = User::permission('check master sample')->pluck('name', 'id')->toArray();
        $this->knowledgeOptions = User::permission('knowladge master sample')->pluck('name', 'id')->toArray();
        $this->approverOptions = User::permission('approve master sample')->pluck('name', 'id')->toArray();
    }
    
    private function resetForm()
    {
        $this->updatedDate = now()->format('Y-m-d');
        $this->expiredDate = now()->addYear()->format('Y-m-d');
        $this->alarmDate = now()->addYear()->subMonth()->format('Y-m-d');
        $this->checkedBy = null;
        $this->knowledgeBy = null;
        $this->approvedBy = null;
        $this->resetValidation();
    }
    
    private function loadExpiredData()
    {
        $detail = DetailMasterSample::find($this->expiredId);
        if (!$detail) {
            session()->flash('error', 'Expired history not found!');
            return redirect()->route('prod.ms.master-sample.expired', $this->masterSample->id);
        }
        
        $this->updatedDate = $detail->updated_date;
        $this->expiredDate = $detail->expired_date;
        $this->alarmDate = $detail->date_alarm;
        $this->checkedBy = $detail->checked_by;
        $this->knowledgeBy = $detail->knowladge_by;
        $this->approvedBy = $detail->approved_by;
    }
    
    public function updatedUpdatedDate($value)
    {
        if ($value) {
            $date = Carbon::parse($value);
            $this->expiredDate = $date->copy()->addYear()->format('Y-m-d');
            $this->alarmDate = $date->copy()->addYear()->subMonth()->format('Y-m-d');
        }
    }
    
    public function save()
    {
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            $data = [
                'master_sample_id' => $this->masterSample->id,
                'updated_date' => $this->updatedDate,
                'expired_date' => $this->expiredDate,
                'date_alarm' => $this->alarmDate,
                'checked_by' => $this->checkedBy,
                'knowladge_by' => $this->knowledgeBy,
                'approved_by' => $this->approvedBy,
            ];
            
            if ($this->isEdit && $this->expiredId) {
                DetailMasterSample::find($this->expiredId)->update($data);
                $message = 'Expired history updated successfully!';
            } else {
                DetailMasterSample::create($data);
                $message = 'Expired history created successfully!';
            }
            
            DB::commit();
            session()->flash('success', $message);
            return redirect()->route('prod.ms.master-sample.expired', $this->masterSample->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.prod.ms.master-sample-expired-form');
    }
}