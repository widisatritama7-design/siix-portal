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
            $this->dispatch('notify', message: 'Tidak ada data untuk di export', type: 'error');
            return;
        }

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

        // Generate QR Code sebagai base64 menggunakan API eksternal (diambil dari server)
        $itemsWithQR = [];
        foreach ($this->selectedItems as $item) {
            // Download QR code dari API dan convert ke base64
            $qrUrl = 'https://quickchart.io/qr?text=' . urlencode($item['register_no']) . '&size=150&margin=2';
            $qrImage = @file_get_contents($qrUrl);
            
            if ($qrImage === false) {
                // Fallback ke API lain
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($item['register_no']);
                $qrImage = @file_get_contents($qrUrl);
            }
            
            $qrBase64 = $qrImage !== false ? 'data:image/png;base64,' . base64_encode($qrImage) : '';
            
            $itemsWithQR[] = [
                'register_no' => $item['register_no'],
                'model' => $item['model'],
                'qr_base64' => $qrBase64
            ];
        }

        $data = [
            'items' => $itemsWithQR,
            'modelLabels' => $modelLabels,
            'date' => now()->format('d-m-Y H:i:s'),
            'total' => count($this->selectedItems)
        ];

        $pdf = Pdf::loadView('livewire.esd.print.qr-codes', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'qr-codes-' . date('Y-m-d-His') . '.pdf');
    }
}