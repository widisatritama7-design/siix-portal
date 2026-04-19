<?php

namespace App\Livewire\PROD\MS\Sample;

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
    public $loanStatus = 'in_use';
    public $loanMasterLineId;
    public $loanRemarks;
    public $isEdit = false;
    public $selectedNikName = '';
    
    public $sampleTypeOptions = [];
    public $nikOptions = [];
    public $lineOptions = [];
    
    protected function rules()
    {
        return [
            'loanTypes' => 'required|array|min:1',
            'loanQty' => 'required|integer|min:1',
            'loanOutDate' => 'required|date',
            'loanNik' => 'required|exists:tb_hr_employee,ID',
            'loanStatus' => 'required|in:in_use,loaning,ecr',
            'loanMasterLineId' => 'required_if:loanStatus,in_use|nullable|exists:tb_mtc_master_lines,id',
            'loanRemarks' => 'required_if:loanStatus,loaning|required_if:loanStatus,ecr|nullable|string',
        ];
    }
    
    protected function messages()
    {
        return [
            'loanTypes.required' => 'Please select at least one sample type.',
            'loanTypes.min' => 'Please select at least one sample type.',
            'loanQty.required' => 'Sample quantity is required.',
            'loanQty.min' => 'Sample quantity must be at least 1.',
            'loanOutDate.required' => 'Out date is required.',
            'loanOutDate.date' => 'Invalid out date format.',
            'loanNik.required' => 'Please select NIK.',
            'loanNik.exists' => 'Selected NIK does not exist.',
            'loanStatus.required' => 'Status is required.',
            'loanStatus.in' => 'Invalid status selected.',
            'loanMasterLineId.required_if' => 'Line is required when status is In Use.',
            'loanMasterLineId.exists' => 'Selected line does not exist.',
            'loanRemarks.required_if' => 'Remarks is required when status is Loaning or ECR.',
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
            ->select('id', 'nik', 'name')
            ->get()
            ->mapWithKeys(fn($e) => [$e->id => $e->nik . ' - ' . $e->name])
            ->toArray();
    }
    
    private function loadLineOptions()
    {
        $usedLineIds = HistoryMasterSample::where('status', 'in_use')
            ->where('master_line_id', '!=', null)
            ->pluck('master_line_id')
            ->filter()
            ->toArray();
            
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
        $this->selectedNikName = '';
        $this->resetValidation();
    }
    
    private function loadLoanData()
    {
        $history = HistoryMasterSample::find($this->loanHistoryId);
        if (!$history) {
            session()->flash('error', 'Loan history not found!');
            return redirect()->route('prod.ms.master-sample.show', ['id' => $this->masterSample->id, 'tab' => 'history']);
        }
        
        // PERBAIKAN: Load type tanpa json_decode berlebihan
        $this->loanTypes = $this->safeDecodeType($history->type);
        $this->loanQty = $history->qty ?? 0;
        $this->loanOutDate = $history->out_date ? Carbon::parse($history->out_date)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i');
        $this->loanNik = $history->nik;
        $this->loanStatus = $history->status ?? 'in_use';
        $this->loanMasterLineId = $history->master_line_id;
        $this->loanRemarks = $history->remarks;
        
        // Set selected NIK name for display
        if ($this->loanNik && isset($this->nikOptions[$this->loanNik])) {
            $this->selectedNikName = $this->nikOptions[$this->loanNik];
        }
    }
    
    private function safeDecodeType($type)
    {
        if (is_null($type)) return [];
        if (is_array($type)) return $type;
        
        $decoded = json_decode($type, true);
        
        // Jika hasil decode adalah string (terjadi double encoding), decode lagi
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }
        
        return is_array($decoded) ? $decoded : [];
    }
    
    public function updatedLoanTypes()
    {
        $this->loanQty = count($this->loanTypes);
    }
    
    public function updatedLoanStatus($value)
    {
        // Reset line if status is not 'in_use'
        if ($value !== 'in_use') {
            $this->loanMasterLineId = null;
        }
        
        // Reset remarks if status is not 'loaning' or 'ecr'
        if (!in_array($value, ['loaning', 'ecr'])) {
            $this->loanRemarks = null;
        }
        
        // Clear validation errors when status changes
        $this->resetValidation(['loanMasterLineId', 'loanRemarks']);
    }
    
    public function save()
    {
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            // PERBAIKAN: Simpan array langsung, tanpa json_encode
            $data = [
                'master_sample_id' => $this->masterSample->id,
                'type' => $this->loanTypes,  // ← LANGSUNG ARRAY, bukan json_encode
                'qty' => $this->loanQty,
                'out_date' => $this->loanOutDate,
                'nik' => $this->loanNik,
                'status' => $this->loanStatus,
                'master_line_id' => $this->loanStatus === 'in_use' ? $this->loanMasterLineId : null,
                'remarks' => $this->loanStatus !== 'in_use' ? $this->loanRemarks : null,
            ];
            
            if ($this->isEdit && $this->loanHistoryId) {
                $history = HistoryMasterSample::find($this->loanHistoryId);
                if ($history) {
                    $history->update($data);
                    $message = 'Loan history updated successfully!';
                } else {
                    throw new \Exception('Loan history not found!');
                }
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
            \Log::error('Loan save error: ' . $e->getMessage(), [
                'data' => $data ?? [],
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.prod.ms.sample.master-sample-loan-form');
    }
}