<?php
// app/Livewire/ESD/Print/MultiModelQrPrinter.php

namespace App\Livewire\ESD\Print;

use Livewire\Component;
use App\Models\ESD\EG\EquipmentGround;
use App\Models\ESD\Flooring\Flooring;
use App\Models\ESD\GB\GroundMonitorBox;
use App\Models\ESD\Insulatif\InsulatifCheck;
use App\Models\ESD\Ionizer\Ionizer;
use App\Models\ESD\Magazine\Magazine;
use App\Models\ESD\Shower\Shower;
use App\Models\ESD\Soldering\Soldering;
use App\Models\ESD\Worksurface\Worksurface;
use App\Models\ESD\WS\WristStrap;
use Barryvdh\DomPDF\Facade\Pdf;

class MultiModelQrPrinter extends Component
{
    public $selectedModel = '';
    public $searchTerm = '';
    public $selectedItems = [];

    public function render()
    {
        $modelLabels = [
            'equipment_ground' => 'Equipment Ground',
            'flooring' => 'Flooring',
            'ground_monitor_box' => 'Ground Monitor Box',
            'insulatif_check' => 'Insulatif Check',
            'ionizer' => 'Ionizer',
            'magazine' => 'Magazine',
            'shower' => 'Shower',
            'soldering' => 'Soldering',
            'worksurface' => 'Worksurface',
            'wrist_strap' => 'Wrist Strap',
        ];

        $modelMap = [
            'equipment_ground' => EquipmentGround::class,
            'flooring' => Flooring::class,
            'ground_monitor_box' => GroundMonitorBox::class,
            'insulatif_check' => InsulatifCheck::class,
            'ionizer' => Ionizer::class,
            'magazine' => Magazine::class,
            'shower' => Shower::class,
            'soldering' => Soldering::class,
            'worksurface' => Worksurface::class,
            'wrist_strap' => WristStrap::class,
        ];

        $fieldMap = [
            EquipmentGround::class => 'machine_name',
            Flooring::class => 'register_no',
            GroundMonitorBox::class => 'register_no',
            InsulatifCheck::class => 'register_no',
            Ionizer::class => 'register_no',
            Magazine::class => 'register_no',
            Shower::class => 'register_no',
            Soldering::class => 'register_no',
            Worksurface::class => 'register_no',
            WristStrap::class => 'register_no',
        ];

        $searchResults = collect();

        if (!empty($this->selectedModel) && !empty($this->searchTerm)) {
            $modelClass = $modelMap[$this->selectedModel] ?? null;
            if ($modelClass) {
                $field = $fieldMap[$modelClass] ?? 'register_no';
                $existingIds = collect($this->selectedItems)->pluck('id')->toArray();
                $searchResults = $modelClass::where($field, 'like', '%' . $this->searchTerm . '%')
                    ->whereNotIn('id', $existingIds)
                    ->limit(10)
                    ->get()
                    ->map(fn($item) => [
                        'id' => $item->id, 
                        'register_no' => $item->$field
                    ]);
            }
        }

        return view('livewire.esd.print.multi-model-qr-printer', [
            'modelLabels' => $modelLabels,
            'searchResults' => $searchResults,
        ]);
    }

    public function addItem($id, $registerNo)
    {
        $exists = collect($this->selectedItems)->contains('id', $id);
        
        if (!$exists) {
            $this->selectedItems[] = [
                'id' => $id,
                'register_no' => $registerNo,
                'model' => $this->selectedModel,
            ];
        }
        
        $this->searchTerm = '';
        $this->dispatch('item-added');
    }

    public function removeItem($index)
    {
        unset($this->selectedItems[$index]);
        $this->selectedItems = array_values($this->selectedItems);
        $this->dispatch('item-removed');
    }

    public function clearAll()
    {
        $this->selectedItems = [];
        $this->searchTerm = '';
        $this->dispatch('items-cleared');
    }

    public function exportPDF()
    {
        if (count($this->selectedItems) == 0) {
            session()->flash('error', 'Tidak ada data untuk di export');
            return;
        }

        // Load logo image
        $logoPath = public_path('images/esd-safe.png');
        $logoBase64 = '';
        
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        } else {
            // Fallback: buat logo sederhana
            $logoBase64 = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23facc15"%3E%3Cpath d="M12 2L1 7l11 5 11-5-11-5zM1 17l11 5 11-5M1 12l11 5 11-5" stroke="%23000" stroke-width="1"/%3E%3C/svg%3E';
        }

        // Urutkan items
        $sortedItems = collect($this->selectedItems)->sortBy(function ($item) {
            $priority = ['ground_monitor_box' => 1, 'equipment_ground' => 2];
            return $priority[$item['model']] ?? 999;
        })->values()->toArray();

        // Generate QR Code untuk setiap item
        $itemsWithQR = [];
        foreach ($sortedItems as $index => $item) {
            $registerNo = $item['register_no'];
            
            // Generate QR code sebagai base64
            $qrUrl = 'https://quickchart.io/qr?text=' . urlencode($registerNo) . '&size=200&margin=2';
            $qrImage = @file_get_contents($qrUrl);
            
            if ($qrImage === false) {
                // Fallback ke API lain
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($registerNo);
                $qrImage = @file_get_contents($qrUrl);
            }
            
            $qrBase64 = ($qrImage !== false) ? 'data:image/png;base64,' . base64_encode($qrImage) : '';
            
            // Jika masih gagal, buat QR code manual via Google Charts API
            if (empty($qrBase64)) {
                $qrUrl = 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' . urlencode($registerNo);
                $qrImage = @file_get_contents($qrUrl);
                $qrBase64 = ($qrImage !== false) ? 'data:image/png;base64,' . base64_encode($qrImage) : '';
            }
            
            $itemsWithQR[] = [
                'register_no' => $registerNo,
                'model' => $item['model'],
                'qr_base64' => $qrBase64,
                'logo_base64' => $logoBase64,
            ];
        }

        // Debug: cek apakah data terisi
        // Log::info('Items with QR:', $itemsWithQR);
        
        $data = [
            'items' => $itemsWithQR,
            'date' => now()->format('d-m-Y H:i:s'),
            'total' => count($itemsWithQR)
        ];

        // Generate PDF
        $pdf = Pdf::loadView('livewire.esd.print.qr-codes', $data);
        $pdf->setPaper('A4', 'portrait');
        
        // Download PDF
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'qr-codes-' . date('Y-m-d-His') . '.pdf');
    }

    public function getCardSize($model)
    {
        $sizeMap = [
            'ground_monitor_box' => ['width' => '227px', 'height' => '45px'],
        ];
        
        return $sizeMap[$model] ?? ['width' => '240px', 'height' => '45px'];
    }
}