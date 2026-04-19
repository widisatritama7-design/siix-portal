<?php

namespace App\Livewire\PROD\MS\Sample;

use App\Models\MTC\Master\MasterArea;
use App\Models\MTC\Master\MasterLine;
use Livewire\Component;

class MasterSampleDashboard extends Component
{
    public $areas = [];
    public $selectedArea = 'all';
    public $selectedLine = null;
    public $lineDetail = null;
    public $loading = false;

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Ambil semua area beserta locations, lines, dan history samples yang in use
        $areas = MasterArea::with(['locations.lines.historyMasterSamples' => function ($q) {
            $q->where('status', 'in_use')->with('masterSample');
        }])->get();
    
        $data = [];
    
        foreach ($areas as $area) {
            $locationsData = [];
            
            foreach ($area->locations as $location) {
                $linesData = [];
                
                foreach ($location->lines as $line) {
                    // Ambil history samples yang sedang in use untuk line ini
                    $historyInUse = $line->historyMasterSamples->where('status', 'in_use');
                    
                    // Kumpulkan tipe sample dari HISTORY
                    $types = [];
                    foreach ($historyInUse as $history) {
                        if ($history->type && is_array($history->type)) {
                            foreach ($history->type as $t) {
                                if (!in_array($t, $types)) {
                                    $types[] = $t;
                                }
                            }
                        }
                    }
                    
                    $linesData[] = [
                        'line_number' => $line->line_number,
                        'types' => $types,
                        'line_id' => $line->id,
                        'has_sample' => count($types) > 0,
                        'history_count' => $historyInUse->count(),
                    ];
                }
                
                // **URUTAN LINE: dari line_number terkecil ke terbesar**
                usort($linesData, function($a, $b) {
                    return $a['line_number'] - $b['line_number'];
                });
                
                if (!empty($linesData)) {
                    $locationsData[] = [
                        'location_id' => $location->id,
                        'location_name' => $location->location_name,
                        'lines' => $linesData,
                        'line_count' => count($linesData), // Jumlah line di location ini
                    ];
                }
            }
            
            // **URUTAN LOCATION: berdasarkan line_count terbanyak ke paling sedikit**
            usort($locationsData, function($a, $b) {
                return $b['line_count'] - $a['line_count'];
            });
            
            if (!empty($locationsData)) {
                $data[] = [
                    'area_id' => $area->id,
                    'area_name' => $area->area_name,
                    'locations' => $locationsData,
                ];
            }
        }
        
        $this->areas = $data;
    }

    public function getFilteredAreas()
    {
        if (empty($this->areas)) {
            return [];
        }
        
        if ($this->selectedArea === 'all') {
            return $this->areas;
        }
        
        // Filter berdasarkan area yang dipilih
        $filterAreaName = $this->selectedArea === '2' ? 'Production 01' : 'Production 02';
        
        return array_filter($this->areas, function($area) use ($filterAreaName) {
            return $area['area_name'] === $filterAreaName;
        });
    }

    public function openLineDetail($lineId, $areaId)
    {
        $this->loading = true;
        
        try {
            $line = MasterLine::with(['location', 'historyMasterSamples' => function($q) {
                $q->where('status', 'in_use')->with(['masterSample', 'employee']);
            }])->find($lineId);
            
            if (!$line) {
                $this->dispatch('notify', message: 'Line not found!', type: 'error');
                return;
            }
            
            // Ambil history in use untuk line ini
            $historiesInUse = $line->historyMasterSamples->where('status', 'in_use');
            
            // Kumpulkan tipe sample dari history
            $sampleTypes = [];
            foreach ($historiesInUse as $history) {
                if ($history->type && is_array($history->type)) {
                    foreach ($history->type as $t) {
                        if (!in_array($t, $sampleTypes)) {
                            $sampleTypes[] = $t;
                        }
                    }
                }
            }
            
            // Ambil master sample pertama (untuk info model dan expired date)
            $firstHistory = $historiesInUse->first();
            $masterSample = $firstHistory?->masterSample;
            
            $expiredDate = null;
            if ($masterSample && $masterSample->details) {
                $latestDetail = $masterSample->details->sortByDesc('expired_date')->first();
                $expiredDate = $latestDetail?->expired_date;
            }
            
            // Kumpulkan semua loaner dari history yang in use
            $loaners = [];
            foreach ($historiesInUse as $history) {
                $loaners[] = [
                    'nik' => $history->employee->nik ?? '-',
                    'employee_name' => $history->employee->name ?? '-',
                    'loan_date' => $history->out_date ? \Carbon\Carbon::parse($history->out_date)->format('d F Y H:i:s') : '-',
                ];
            }
            
            $this->lineDetail = [
                'line_id' => $line->id,
                'line_number' => $line->line_number,
                'area_id' => $areaId,
                'area_name' => $areaId == 2 ? 'Production 01' : 'Production 02',
                'location_name' => $line->location->location_name ?? '-',
                'model_name' => $masterSample->model_name ?? '-',
                'expired_date' => $expiredDate ? \Carbon\Carbon::parse($expiredDate)->format('d F Y') : '-',
                'sample_types' => $sampleTypes,
                'master_sample_id' => $masterSample?->id,
                'loaners' => $loaners,
                'total_loaners' => count($loaners),
            ];
            
            $this->dispatch('open-line-modal');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->loading = false;
        }
    }
    
    public function closeLineModal()
    {
        $this->lineDetail = null;
        $this->dispatch('close-line-modal');
    }
    
    public function getSampleBadgeClass($type)
    {
        return match($type) {
            'sample_ok' => 'bg-green-500',
            'sample_ok_backup' => 'bg-blue-500',
            'sample_ng' => 'bg-red-500',
            'sample_blank' => 'bg-gray-400',
            default => 'bg-gray-300',
        };
    }
    
    public function getSampleTitle($type)
    {
        return match($type) {
            'sample_ok' => 'OK Sample',
            'sample_ok_backup' => 'OK Backup Sample',
            'sample_ng' => 'NG Sample',
            'sample_blank' => 'Blank Sample',
            default => 'Unknown',
        };
    }

    public function render()
    {
        $filteredAreas = $this->getFilteredAreas();
        
        return view('livewire.prod.ms.sample.master-sample-dashboard', [
            'filteredAreas' => $filteredAreas,
        ]);
    }
}