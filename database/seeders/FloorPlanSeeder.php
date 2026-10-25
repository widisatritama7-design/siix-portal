<?php

namespace Database\Seeders;

use App\Models\FloorItem;
use App\Models\FloorPlan;
use Illuminate\Database\Seeder;

class FloorPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plan = FloorPlan::firstOrCreate([
            'name' => 'Demo Warehouse — Floor Plan',
            'grid_width' => 1000,
            'grid_height' => 800,
        ]);

        // ==========================================
        // LEVEL 1: AREA (Di bawah Floor Plan)
        // ==========================================
        $prod01 = FloorItem::create([
            'floor_plan_id' => $plan->id,
            'parent_id' => null, // Root level
            'level' => 1,
            'type' => 'area',
            'label' => 'PRODUCTION 01',
            'x' => 40, 'y' => 40, 'width' => 200, 'height' => 150,
            'config' => ['color' => '#3b82f6', 'link' => ''],
        ]);

        $whMaterial = FloorItem::create([
            'floor_plan_id' => $plan->id,
            'parent_id' => null, 
            'level' => 1,
            'type' => 'area',
            'label' => 'WH MATERIAL',
            'x' => 280, 'y' => 40, 'width' => 200, 'height' => 150,
            'config' => ['color' => '#eab308', 'link' => ''],
        ]);

        // ==========================================
        // LEVEL 2: LOCATION (Di bawah Area)
        // ==========================================
        $locationSmt = FloorItem::create([
            'floor_plan_id' => $plan->id,
            'parent_id' => $whMaterial->id, // Masuk ke WH MATERIAL
            'level' => 2,
            'type' => 'location',
            'label' => 'SMT',
            'x' => 40, 'y' => 40, 'width' => 150, 'height' => 120,
            'config' => ['color' => '#22c55e', 'link' => ''],
        ]);

        // ==========================================
        // LEVEL 3: LINE (Di bawah Location)
        // ==========================================
        $lineSmt1 = FloorItem::create([
            'floor_plan_id' => $plan->id,
            'parent_id' => $locationSmt->id, // Masuk ke SMT
            'level' => 3,
            'type' => 'line',
            'label' => 'SMT 1',
            'x' => 40, 'y' => 40, 'width' => 120, 'height' => 100,
            'config' => ['color' => '#a855f7', 'link' => ''],
        ]);

        // ==========================================
        // LEVEL 4: ITEMS (Di bawah Line)
        // ==========================================
        FloorItem::create([
            'floor_plan_id' => $plan->id,
            'parent_id' => $lineSmt1->id, // Masuk ke SMT 1
            'level' => 4,
            'type' => 'item',
            'label' => 'Ionizer',
            'x' => 40, 'y' => 40, 'width' => 80, 'height' => 80,
            'config' => [
                'color' => '#ef4444', 
                'link' => '',
                'register_number' => 'SMT1/ION/2610-001'
            ],
        ]);
    }
}