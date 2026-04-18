<?php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\WIP\MasterWip;
use App\Models\PROD\WIP\MasterModel;
use Carbon\Carbon;

class MasterWipManagement extends Component
{
    use WithPagination;

    // Form properties
    public $wip_id;
    public $model;
    public $part_number = '';
    public $dj;
    public $lot_qty;
    public $acceptance_status = '';
    public $approval = '';

    // Filter properties
    public $search = '';
    public $status = '';
    public $date_from = '';
    public $date_to = '';

    // Modal properties
    public $modalTitle = 'Add New WIP';
    public $wipToDelete = null;

    protected function rules()
    {
        return [
            'model' => 'required|exists:tb_prod_master_models,model',
            'part_number' => 'nullable|string|max:255',
            'dj' => 'required|string|max:255|unique:tb_prod_master_wips,dj,' . $this->wip_id,
            'lot_qty' => 'required|integer|min:1',
            'acceptance_status' => 'nullable|string|max:255',
            'approval' => 'nullable|string|max:255',
        ];
    }

    protected $messages = [
        'model.required' => 'Model is required.',
        'model.exists' => 'Selected model does not exist.',
        'dj.required' => 'PrdOrd is required.',
        'dj.unique' => 'This PrdOrd already exists.',
        'lot_qty.required' => 'Lot quantity is required.',
        'lot_qty.integer' => 'Lot quantity must be a number.',
        'lot_qty.min' => 'Lot quantity must be at least 1.',
    ];

    public function resetForm()
    {
        $this->reset(['wip_id', 'model', 'part_number', 'dj', 'lot_qty', 'acceptance_status', 'approval']);
        $this->modalTitle = 'Add New WIP';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function updatedModel($value)
    {
        if ($value) {
            $masterModel = MasterModel::where('model', $value)->first();
            if ($masterModel) {
                $this->part_number = $masterModel->part_number;
            }
        } else {
            $this->part_number = '';
        }
    }

    public function save()
    {
        if ($this->wip_id) {
            if (!auth()->user()->can('edit wip')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create wip')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'model' => $this->model,
            'part_number' => $this->part_number,
            'dj' => $this->dj,
            'lot_qty' => $this->lot_qty,
            'acceptance_status' => $this->acceptance_status,
            'approval' => $this->approval,
        ];

        if ($this->wip_id) {
            $wip = MasterWip::find($this->wip_id);
            if (!$wip) {
                $this->dispatch('notify', message: 'WIP not found!', type: 'error');
                return;
            }

            $wip->update($data);
            $message = 'WIP updated successfully!';
        } else {
            MasterWip::create($data);
            $message = 'WIP created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'wip-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit wip')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $wip = MasterWip::find($id);

        if (!$wip) {
            $this->dispatch('notify', message: 'WIP not found!', type: 'error');
            return;
        }

        $this->wip_id = $wip->id;
        $this->model = $wip->model;
        $this->part_number = $wip->part_number;
        $this->dj = $wip->dj;
        $this->lot_qty = $wip->lot_qty;
        $this->acceptance_status = $wip->acceptance_status;
        $this->approval = $wip->approval;
        $this->modalTitle = 'Edit WIP';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete wip')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $wip = MasterWip::find($id);

        if (!$wip) {
            $this->dispatch('notify', message: 'WIP not found!', type: 'error');
            return;
        }

        // Check if has scans
        if ($wip->detailWips()->count() > 0) {
            $this->dispatch('notify', message: 'Cannot delete WIP with existing scans!', type: 'error');
            return;
        }

        $this->wipToDelete = $wip;
        $this->dispatch('open-modal', 'delete-wip-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete wip')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $wip = MasterWip::find($this->wipToDelete->id);

        if (!$wip) {
            $this->dispatch('notify', message: 'WIP not found!', type: 'error');
            $this->wipToDelete = null;
            return;
        }

        $wipName = $wip->dj;
        $wip->delete();

        $this->wipToDelete = null;
        $this->dispatch('notify', message: "WIP '{$wipName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-wip-modal');
    }

    public function cancelDelete()
    {
        $this->wipToDelete = null;
        $this->dispatch('close-modal', 'delete-wip-modal');
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->date_from = '';
        $this->date_to = '';
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->user()->can('view wip')) {
            abort(403);
        }
    
        // 1. QUERY UTAMA UNTUK PAGINASI (hanya ambil data yang dibutuhkan)
        $query = MasterWip::query()
            ->with(['creator']) // Hanya load creator, karena detailWips tidak ditampilkan di tabel utama
            ->withCount('detailWips as scans_count')
            ->withMax('detailWips as current_acm', 'acm');
    
        // Apply search filter ke query utama
        if ($this->search) {
            $query->where(function($q) {
                $q->where('model', 'like', "%{$this->search}%")
                  ->orWhere('part_number', 'like', "%{$this->search}%")
                  ->orWhere('dj', 'like', "%{$this->search}%");
            });
        }
    
        // Apply date range filter
        if ($this->date_from) {
            $query->whereDate('created_at', '>=', $this->date_from);
        }
        if ($this->date_to) {
            $query->whereDate('created_at', '<=', $this->date_to);
        }
    
        // 2. HITUNG STATUS COUNTS DENGAN QUERY TERPISAH (EFISIEN)
        // Kita buat query builder baru untuk menghitung status tanpa eager loading yang berat
        $statusQuery = MasterWip::query();
        
        // Apply filter yang SAMA (search & date) ke query status, karena counts harus sesuai filter
        if ($this->search) {
            $statusQuery->where(function($q) {
                $q->where('model', 'like', "%{$this->search}%")
                  ->orWhere('part_number', 'like', "%{$this->search}%")
                  ->orWhere('dj', 'like', "%{$this->search}%");
            });
        }
        if ($this->date_from) {
            $statusQuery->whereDate('created_at', '>=', $this->date_from);
        }
        if ($this->date_to) {
            $statusQuery->whereDate('created_at', '<=', $this->date_to);
        }
    
        // Ambil semua ID WIP yang sudah difilter
        $filteredWipIds = $statusQuery->pluck('id'); // Query 1: SELECT id FROM ...
    
        // Hitung status berdasarkan ID yang sudah difilter (tanpa mengambil semua kolom)
        // Kita perlu data lot_qty, acm untuk menentukan status. Ambil minimal yang diperlukan.
        $allFilteredWips = MasterWip::whereIn('id', $filteredWipIds)
            ->withMax('detailWips as current_acm', 'acm') // butuh acm
            ->get(['id', 'lot_qty']); // Query 2: SELECT id, lot_qty FROM ... WHERE IN (...)
    
        $statusCounts = [
            'Open' => $allFilteredWips->filter(fn($wip) => $wip->lot_qty > 0 && ($wip->current_acm ?? 0) == 0)->count(),
            'In Progress' => $allFilteredWips->filter(fn($wip) => $wip->lot_qty > 0 && ($wip->current_acm ?? 0) > 0 && ($wip->current_acm ?? 0) < $wip->lot_qty)->count(),
            'Finished' => $allFilteredWips->filter(fn($wip) => $wip->lot_qty > 0 && ($wip->current_acm ?? 0) >= $wip->lot_qty)->count(),
        ];
    
        // 3. TERAPKAN FILTER STATUS KE QUERY UTAMA (menggunakan subquery yang efisien)
        if ($this->status) {
            // Cari ID yang sesuai status dari koleksi $allFilteredWips yang sudah kita punya
            $statusFilteredIds = $allFilteredWips->filter(function($wip) {
                $acm = $wip->current_acm ?? 0;
                $lot = $wip->lot_qty;
                if ($this->status === 'Open') return $lot > 0 && $acm == 0;
                if ($this->status === 'In Progress') return $lot > 0 && $acm > 0 && $acm < $lot;
                if ($this->status === 'Finished') return $lot > 0 && $acm >= $lot;
                return false;
            })->pluck('id');
    
            if ($statusFilteredIds->isEmpty()) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('id', $statusFilteredIds);
            }
        }
    
        // 4. PAGINASI
        $wips = $query->latest()->paginate(10); // Query 3: SELECT ... LIMIT 10
    
        // Ambil models untuk dropdown
        $availableModels = MasterModel::orderBy('model')->get();
    
        return view('livewire.prod.wip.master-wip-management', [
            'wips' => $wips,
            'statusCounts' => $statusCounts,
            'availableModels' => $availableModels,
        ]);
    }
}