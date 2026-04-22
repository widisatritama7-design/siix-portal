<?php

namespace App\Http\Controllers;

use App\Models\ESD\EG\EquipmentGround;
use App\Models\ESD\Flooring\Flooring;
use App\Models\ESD\Garment\Garment;
use App\Models\ESD\GB\GroundMonitorBox;
use App\Models\ESD\Glove\Glove;
use App\Models\ESD\Ionizer\Ionizer;
use App\Models\ESD\Jig\Jig;
use App\Models\ESD\Magazine\Magazine;
use App\Models\ESD\Packaging\Packaging;
use App\Models\ESD\Shower\Shower;
use App\Models\ESD\Soldering\Soldering;
use App\Models\ESD\Worksurface\Worksurface;
use App\Models\PROD\MS\MasterSample;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchEquipmentGrounds(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $results = collect();
        
        // ========== ESD EQUIPMENT ==========
        
        // 1. EquipmentGround
        $equipmentGrounds = EquipmentGround::where('machine_name', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->machine_name,
                'type' => 'equipment_ground',
                'url' => "/esd/equipment-grounds/{$item->id}",
            ]);
        
        // 2. Flooring
        $floorings = Flooring::where('register_no', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->register_no ?? 'Flooring',
                'type' => 'flooring',
                'url' => route('esd.floorings.show', $item->id),
            ]);
        
        // 3. Garment
        $garments = Garment::where('nik', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->nik ?? 'Garment',
                'type' => 'garment',
                'url' => route('esd.garments.show', $item->id),
            ]);
        
        // 4. GroundMonitorBox
        $groundMonitorBoxes = GroundMonitorBox::where('register_no', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->register_no ?? 'Ground Monitor Box',
                'type' => 'ground_monitor_box',
                'url' => route('esd.ground-monitor-boxs.show', $item->id),
            ]);
        
        // 5. Glove
        $gloves = Glove::where('sap_code', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->sap_code ?? 'Glove',
                'type' => 'glove',
                'url' => route('esd.gloves.show', $item->id),
            ]);
        
        // 6. Ionizer
        $ionizers = Ionizer::where('register_no', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->register_no ?? 'Ionizer',
                'type' => 'ionizer',
                'url' => route('esd.ionizers.show', $item->id),
            ]);
        
        // 7. Jig
        $jigs = Jig::where('register_no', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->register_no ?? 'Jig',
                'type' => 'jig',
                'url' => route('esd.jigs.show', $item->id),
            ]);
        
        // 8. Magazine
        $magazines = Magazine::where('register_no', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->register_no ?? 'Magazine',
                'type' => 'magazine',
                'url' => route('esd.magazines.show', $item->id),
            ]);
        
        // 9. Packaging
        $packagings = Packaging::where('sap_code', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->sap_code ?? 'Packaging',
                'type' => 'packaging',
                'url' => route('esd.packagings.show', $item->id),
            ]);
        
        // 10. Shower
        $showers = Shower::where('register_no', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->register_no ?? 'Shower',
                'type' => 'shower',
                'url' => route('esd.showers.show', $item->id),
            ]);
        
        // 11. Soldering
        $solderings = Soldering::where('register_no', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->register_no ?? 'Soldering',
                'type' => 'soldering',
                'url' => route('esd.solderings.show', $item->id),
            ]);
        
        // 12. Worksurface
        $worksurfaces = Worksurface::where('register_no', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->register_no ?? 'Worksurface',
                'type' => 'worksurface',
                'url' => route('esd.worksurfaces.show', $item->id),
            ]);
        
        // ========== MASTER SAMPLE (PROD MS) ==========
        // BISA MENCARI: model_name, sample_ok, sample_ok_backup, sample_ng, sample_blank
        $masterSamples = MasterSample::where('model_name', 'like', "%{$query}%")
            ->orWhere('sample_ok', 'like', "%{$query}%")
            ->orWhere('sample_ok_backup', 'like', "%{$query}%")
            ->orWhere('sample_ng', 'like', "%{$query}%")
            ->orWhere('sample_blank', 'like', "%{$query}%")
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'machine_name' => $item->model_name,           // nama model sebagai utama
                'sample_ok' => $item->sample_ok,               // sample OK
                'sample_ok_backup' => $item->sample_ok_backup, // sample OK backup
                'sample_ng' => $item->sample_ng,               // sample NG
                'sample_blank' => $item->sample_blank,         // sample blank
                'type' => 'master_sample',
                'url' => route('prod.ms.master-sample.show', $item->id),
            ]);
        
        // Gabungkan semua hasil
        $results = $equipmentGrounds
            ->concat($floorings)
            ->concat($garments)
            ->concat($groundMonitorBoxes)
            ->concat($gloves)
            ->concat($ionizers)
            ->concat($jigs)
            ->concat($magazines)
            ->concat($packagings)
            ->concat($showers)
            ->concat($solderings)
            ->concat($worksurfaces)
            ->concat($masterSamples)
            ->take(20);
        
        return response()->json($results);
    }
}