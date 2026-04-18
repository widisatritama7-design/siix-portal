<?php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use App\Models\PROD\WIP\MasterWip;
use App\Models\PROD\WIP\MasterModel;
use App\Models\PROD\WIP\DetailWip;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HistoryWipTransaction extends Component
{
    // Filter properties
    public $selectedModels = [];
    public $selectedPrdOrds = [];
    public $dateFrom = null;
    public $dateTo = null;
    public $showResults = false;
    public $isLoading = false;
    public $isExporting = false;
    
    // Search properties
    public $searchModel = '';
    public $searchPrdOrd = '';
    
    // Data
    public $data = [];
    public $models = [];
    public $availablePrdOrds = [];
    
    protected $queryString = [
        'selectedModels' => ['except' => []],
        'selectedPrdOrds' => ['except' => []],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];
    
    public function mount()
    {
        $this->loadModels();
        $this->loadFiltersFromSession();
        
        if (!empty($this->selectedModels)) {
            $this->updatedSelectedModels();
        }
    }
    
    protected function loadModels()
    {
        $this->models = MasterModel::select('model')
            ->distinct()
            ->orderBy('model')
            ->get()
            ->map(fn($item) => [
                'id' => $item->model,
                'name' => $item->model,
            ])
            ->values()
            ->toArray();
    }
    
    protected function loadFiltersFromSession()
    {
        $this->selectedModels = session()->get('wip_history_models', []);
        $this->selectedPrdOrds = session()->get('wip_history_prdords', []);
        $this->dateFrom = session()->get('wip_history_date_from');
        $this->dateTo = session()->get('wip_history_date_to');
    }
    
    protected function saveFiltersToSession()
    {
        session()->put('wip_history_models', $this->selectedModels);
        session()->put('wip_history_prdords', $this->selectedPrdOrds);
        session()->put('wip_history_date_from', $this->dateFrom);
        session()->put('wip_history_date_to', $this->dateTo);
    }
    
    public function updatedSelectedModels()
    {
        if (empty($this->selectedModels)) {
            $this->availablePrdOrds = [];
            $this->selectedPrdOrds = [];
            return;
        }
        
        $this->availablePrdOrds = MasterWip::whereIn('model', $this->selectedModels)
            ->select('dj')
            ->distinct()
            ->whereNotNull('dj')
            ->orderBy('dj')
            ->get()
            ->map(fn($item) => [
                'name' => $item->dj,
            ])
            ->values()
            ->toArray();
        
        $availablePrdOrdNames = collect($this->availablePrdOrds)->pluck('name')->toArray();
        $this->selectedPrdOrds = array_intersect($this->selectedPrdOrds, $availablePrdOrdNames);
    }
    
    public function toggleModel($modelName)
    {
        if (in_array($modelName, $this->selectedModels)) {
            $this->selectedModels = array_values(array_diff($this->selectedModels, [$modelName]));
        } else {
            $this->selectedModels[] = $modelName;
            $this->selectedModels = array_values($this->selectedModels);
        }
        
        $this->updatedSelectedModels();
    }
    
    public function togglePrdOrd($prdOrd)
    {
        if (in_array($prdOrd, $this->selectedPrdOrds)) {
            $this->selectedPrdOrds = array_values(array_diff($this->selectedPrdOrds, [$prdOrd]));
        } else {
            $this->selectedPrdOrds[] = $prdOrd;
            $this->selectedPrdOrds = array_values($this->selectedPrdOrds);
        }
    }
    
    public function selectAllModels()
    {
        $this->selectedModels = collect($this->models)->pluck('id')->toArray();
        $this->updatedSelectedModels();
    }
    
    public function deselectAllModels()
    {
        $this->selectedModels = [];
        $this->availablePrdOrds = [];
        $this->selectedPrdOrds = [];
        $this->searchModel = '';
    }
    
    public function selectAllPrdOrds()
    {
        $this->selectedPrdOrds = collect($this->availablePrdOrds)->pluck('name')->toArray();
    }
    
    public function deselectAllPrdOrds()
    {
        $this->selectedPrdOrds = [];
        $this->searchPrdOrd = '';
    }
    
    public function getFilteredModels()
    {
        if (empty($this->searchModel)) {
            return $this->models;
        }
        
        return collect($this->models)
            ->filter(fn($model) => stripos($model['name'], $this->searchModel) !== false)
            ->values()
            ->toArray();
    }
    
    public function getFilteredPrdOrds()
    {
        if (empty($this->searchPrdOrd)) {
            return $this->availablePrdOrds;
        }
        
        return collect($this->availablePrdOrds)
            ->filter(fn($prdOrd) => stripos($prdOrd['name'], $this->searchPrdOrd) !== false)
            ->values()
            ->toArray();
    }
    
    public function filter()
    {
        $this->isLoading = true;
        
        if (empty($this->selectedModels)) {
            $this->dispatch('notify', message: 'Pilih minimal 1 Model', type: 'warning');
            $this->isLoading = false;
            return;
        }
        
        if (empty($this->selectedPrdOrds)) {
            $this->dispatch('notify', message: 'Pilih minimal 1 PrdOrd', type: 'warning');
            $this->isLoading = false;
            return;
        }
        
        if ($this->dateFrom && $this->dateTo && Carbon::parse($this->dateFrom)->gt(Carbon::parse($this->dateTo))) {
            $this->dispatch('notify', message: 'Tanggal "Dari" tidak boleh lebih besar dari tanggal "Sampai"', type: 'error');
            $this->isLoading = false;
            return;
        }
        
        $this->saveFiltersToSession();
        
        try {
            $query = DetailWip::query()
                ->join('tb_prod_master_wips', 'tb_prod_detail_wips.master_wips_id', '=', 'tb_prod_master_wips.id')
                ->whereIn('tb_prod_master_wips.model', $this->selectedModels)
                ->whereIn('tb_prod_master_wips.dj', $this->selectedPrdOrds)
                ->select('tb_prod_detail_wips.*');
            
            if ($this->dateFrom) {
                $query->whereDate('tb_prod_detail_wips.created_at', '>=', Carbon::parse($this->dateFrom)->startOfDay());
            }
            
            if ($this->dateTo) {
                $query->whereDate('tb_prod_detail_wips.created_at', '<=', Carbon::parse($this->dateTo)->endOfDay());
            }
            
            $this->data = $query->orderBy('tb_prod_detail_wips.created_at', 'desc')->get();
            $this->data->load(['masterWip', 'creator', 'updater']);
            
            $this->showResults = true;
            
            $this->dispatch('notify', message: 'Menampilkan ' . $this->data->count() . ' data transaksi', type: 'success');
            
        } catch (\Exception $e) {
            \Log::error('Filter error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Terjadi kesalahan: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isLoading = false;
        }
    }
    
    public function resetFilter()
    {
        $this->selectedModels = [];
        $this->selectedPrdOrds = [];
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->data = [];
        $this->showResults = false;
        $this->availablePrdOrds = [];
        $this->searchModel = '';
        $this->searchPrdOrd = '';
        
        session()->forget([
            'wip_history_models',
            'wip_history_prdords',
            'wip_history_date_from',
            'wip_history_date_to'
        ]);
        
        $this->dispatch('notify', message: 'Filter telah direset', type: 'success');
    }
    
    public function getSummaryStats()
    {
        return [
            'total_qty' => $this->data->sum('qty'),
            'total_ng' => $this->data->sum('ng_count'),
            'total_acm' => $this->data->sum('acm'),
            'total_balance' => $this->data->sum('balance'),
            'unique_models' => $this->data->pluck('masterWip.model')->unique()->count(),
            'unique_prdords' => $this->data->pluck('masterWip.dj')->unique()->count(),
        ];
    }
    
    public function exportToXlsx()
    {
        if ($this->data->isEmpty()) {
            $this->dispatch('notify', message: 'Tidak ada data untuk diexport', type: 'warning');
            return;
        }
        
        $this->isExporting = true;
        
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set title
            $sheet->setTitle('WIP History');
            
            // Headers
            $headers = ['NO BOX', 'MODEL', 'PART NUMBER', 'PRD ORD', 'QTY OK', 'QTY NG', 'ACM', 'BALANCE', 'STATUS', 'NO HU', 'REMARKS', 'TANGGAL SCAN', 'SCAN BY'];
            
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $col++;
            }
            
            // Data - nomor urut dari bawah (descending)
            $totalData = $this->data->count();
            $row = 2;
            $rowNumber = $totalData; // Mulai dari total data
            foreach ($this->data as $item) {
                $sheet->setCellValue('A' . $row, $rowNumber); // Nomor urut dari total, total-1, total-2, ...
                $sheet->setCellValue('B' . $row, $item->masterWip->model ?? '-');
                $sheet->setCellValue('C' . $row, $item->masterWip->part_number ?? '-');
                $sheet->setCellValue('D' . $row, $item->masterWip->dj ?? '-');
                $sheet->setCellValue('E' . $row, $item->qty);
                $sheet->setCellValue('F' . $row, $item->ng_count);
                $sheet->setCellValue('G' . $row, $item->acm);
                $sheet->setCellValue('H' . $row, $item->balance);
                $sheet->setCellValue('I' . $row, $item->status ?? '-');
                $sheet->setCellValue('J' . $row, $item->no_hu ?? '-');
                $sheet->setCellValue('K' . $row, $item->remarks ?? '-');
                $sheet->setCellValue('L' . $row, $item->created_at ? Carbon::parse($item->created_at)->format('d/m/Y H:i:s') : '-');
                $sheet->setCellValue('M' . $row, $item->creator->name ?? '-');
                $row++;
                $rowNumber--; // Kurangi setiap iterasi
            }
            
            // Auto size columns
            foreach (range('A', 'M') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Create writer
            $writer = new Xlsx($spreadsheet);
            
            // Save to temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'wip_export_');
            $writer->save($tempFile);
            
            $filename = 'wip_history_' . Carbon::now()->format('Ymd_His') . '.xlsx';
            
            $this->isExporting = false;
            $this->dispatch('notify', message: 'Export Excel sedang diproses...', type: 'success');
            
            return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            $this->isExporting = false;
            $this->dispatch('notify', message: 'Error export: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function render()
    {
        return view('livewire.prod.wip.history-wip-transaction', [
            'filteredModels' => $this->getFilteredModels(),
            'filteredPrdOrds' => $this->getFilteredPrdOrds(),
            'stats' => $this->showResults ? $this->getSummaryStats() : null,
        ]);
    }
}