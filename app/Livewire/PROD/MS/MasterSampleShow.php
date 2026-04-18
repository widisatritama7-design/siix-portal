<?php

namespace App\Livewire\PROD\MS;

use App\Models\PROD\MS\DetailMasterSample;
use App\Models\PROD\MS\HistoryMasterSample;
use App\Models\PROD\MS\MasterSample;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class MasterSampleShow extends Component
{
    use WithPagination;
    
    public $masterSample;
    public $activeRelationTab = 'history';
    public $perPage = 10;
    
    public function mount($id, $tab = 'history')
    {
        $this->activeRelationTab = $tab;
        $this->masterSample = MasterSample::with(['rack'])->findOrFail($id);
        
        if (!auth()->user()->can('view master sample')) {
            abort(403, 'Unauthorized access.');
        }
    }
    
    private function safeDecodeType($type)
    {
        if (is_null($type)) return [];
        if (is_array($type)) return $type;
        $decoded = json_decode($type, true);
        return is_array($decoded) ? $decoded : [];
    }
    
    public function deleteLoan($id)
    {
        HistoryMasterSample::find($id)?->delete();
        $this->dispatch('notify', message: 'Loan history deleted!', type: 'success');
        $this->resetPage();
    }
    
    public function deleteExpired($id)
    {
        DetailMasterSample::find($id)?->delete();
        $this->dispatch('notify', message: 'Expired history deleted!', type: 'success');
        $this->resetPage();
    }
    
    public function setRelationTab($tab)
    {
        $this->activeRelationTab = $tab;
        $this->resetPage();
    }
    
    private function canAddLoan()
    {
        $expiredDate = $this->masterSample->latestDetail?->expired_date;
        if ($expiredDate && now()->greaterThanOrEqualTo($expiredDate->startOfDay())) return false;
        $lastRecord = $this->masterSample->historydDetails()->latest('out_date')->first();
        return !$lastRecord || !is_null($lastRecord->in_date);
    }
    
    public function getHistoriesProperty()
    {
        return HistoryMasterSample::where('master_sample_id', $this->masterSample->id)
            ->with(['employee', 'masterLine.location'])
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }
    
    public function getDetailsProperty()
    {
        return DetailMasterSample::where('master_sample_id', $this->masterSample->id)
            ->with(['checkedBy', 'knowladgeBy', 'approvedBy'])
            ->orderByDesc('created_at')
            ->paginate($this->perPage)
            ->through(function ($item) {
                if ($item->expired_date) {
                    $expired = Carbon::parse($item->expired_date)->startOfDay();
                    $diff = Carbon::today()->diffInDays($expired, false);
                    $item->days_left = $diff > 0 ? "$diff hari" : ($diff === 0 ? 'Hari ini' : ($diff < 0 ? 'Lewat ' . abs($diff) . ' hari' : '-'));
                } else {
                    $item->days_left = '-';
                }
                return $item;
            });
    }
    
    public function render()
    {
        return view('livewire.prod.ms.master-sample-show', [
            'histories' => $this->histories,
            'details' => $this->details,
            'canAddLoan' => $this->canAddLoan(),
            'canAddExpired' => $this->masterSample->details()->count() === 0,
        ]);
    }
}