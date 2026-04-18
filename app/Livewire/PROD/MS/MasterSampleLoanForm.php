<?php

namespace App\Livewire\PROD\MS;

use App\Models\HR\Employee;
use App\Models\MTC\Master\MasterLine;
use App\Models\PROD\MS\HistoryMasterSample;
use App\Models\PROD\MS\MasterSample;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MasterSampleLoanForm extends Component
{
    public $masterSample;
    public $loanHistoryId = null;
    public $loanTypes = [];
    public $loanQty = 0;
    public $loanOutDate;
    public $loanNik;
    public $loanStatus;
    public $loanMasterLineId;
    public $loanRemarks;
    public $isEdit = false;
    
    public $sampleTypeOptions = [];
    public $nikOptions = [];
    public $lineOptions = [];
    
    protected function rules()
    {
        return [
            'loanTypes' => 'required|array|min:1',
            'loanQty' => 'required|integer|min:1',
            'loanOutDate' => 'required|date',
            'loanNik' => 'required|exists:tb_hr_employee,id',
            'loanStatus' => 'required|in:in_use,loaning,ecr',
            'loanMasterLineId' => 'required_if:loanStatus,in_use|exists:tb_mtc_master_lines,id',
            'loanRemarks' => 'required_if:loanStatus,loaning,ecr|nullable|string',
        ];
    }
    
    public function mount($sampleId, $id = null)
    {
        $this->masterSample = MasterSample::findOrFail($sampleId);
        
        if (!auth()->user()->can('view master sample')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadSampleTypeOptions();
        $this->loadNikOptions();
        $this->loadLineOptions();
        
        if ($id) {
            $this->isEdit = true;
            $this->loanHistoryId = $id;
            $this->loadLoanData();
        } else {
            $this->resetForm();
        }
    }
    
    private function loadSampleTypeOptions()
    {
        $options = [];
        if (!empty($this->masterSample->sample_ok)) $options['sample_ok'] = 'Sample OK';
        if ($this->masterSample->sample_ok_backup) $options['sample_ok_backup'] = 'Sample OK Backup';
        if (!empty($this->masterSample->sample_ng)) $options['sample_ng'] = 'Sample NG';
        if ($this->masterSample->sample_blank) $options['sample_blank'] = 'Sample Blank';
        $this->sampleTypeOptions = $options;
    }
    
    private function loadNikOptions()
    {
        $this->nikOptions = Employee::query()
            ->whereIn('status', [1, 2, 3])
            ->select('ID', 'nik', 'name')
            ->get()
            ->mapWithKeys(fn($e) => [$e->ID => $e->nik . ' - ' . $e->name])
            ->toArray();
    }
    
    private function loadLineOptions()
    {
        $usedLineIds = HistoryMasterSample::where('status', 'in_use')->pluck('master_line_id')->filter()->toArray();
        $this->lineOptions = MasterLine::with('location')
            ->whereNotIn('id', $usedLineIds)
            ->get()
            ->mapWithKeys(fn($line) => [$line->id => ($line->location->location_name ?? 'Unknown') . ' - Line ' . $line->line_number])
            ->toArray();
    }
    
    private function resetForm()
    {
        $this->loanOutDate = now()->format('Y-m-d\TH:i');
        $this->loanStatus = 'in_use';
        $this->loanTypes = [];
        $this->loanQty = 0;
        $this->loanNik = null;
        $this->loanMasterLineId = null;
        $this->loanRemarks = null;
        $this->resetValidation();
    }
    
    private function loadLoanData()
    {
        $history = HistoryMasterSample::find($this->loanHistoryId);
        if (!$history) {
            session()->flash('error', 'Loan history not found!');
            return redirect()->route('prod.ms.master-sample.show', ['id' => $this->masterSample->id, 'tab' => 'history']);
        }
        
        $this->loanTypes = $this->safeDecodeType($history->type);
        $this->loanQty = $history->qty ?? 0;
        $this->loanOutDate = $history->out_date ? Carbon::parse($history->out_date)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i');
        $this->loanNik = $history->nik;
        $this->loanStatus = $history->status ?? 'in_use';
        $this->loanMasterLineId = $history->master_line_id;
        $this->loanRemarks = $history->remarks;
    }
    
    private function safeDecodeType($type)
    {
        if (is_null($type)) return [];
        if (is_array($type)) return $type;
        $decoded = json_decode($type, true);
        return is_array($decoded) ? $decoded : [];
    }
    
    public function updatedLoanTypes()
    {
        $this->loanQty = count($this->loanTypes);
    }
    
    public function updatedLoanStatus($value)
    {
        if ($value !== 'in_use') $this->loanMasterLineId = null;
    }
    
    public function save()
    {
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            $data = [
                'master_sample_id' => $this->masterSample->id,
                'type' => json_encode($this->loanTypes),
                'qty' => $this->loanQty,
                'out_date' => $this->loanOutDate,
                'nik' => $this->loanNik,
                'status' => $this->loanStatus,
                'master_line_id' => $this->loanStatus === 'in_use' ? $this->loanMasterLineId : null,
                'remarks' => $this->loanRemarks,
            ];
            
            if ($this->isEdit && $this->loanHistoryId) {
                HistoryMasterSample::find($this->loanHistoryId)->update($data);
                $message = 'Loan history updated successfully!';
            } else {
                HistoryMasterSample::create($data);
                $message = 'Loan history created successfully!';
            }
            
            DB::commit();
            session()->flash('success', $message);
            return redirect()->route('prod.ms.master-sample.show', ['id' => $this->masterSample->id, 'tab' => 'history']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.prod.ms.master-sample-loan-form');
    }
}