<?php

namespace App\Livewire\Inventory;

use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\FloorPlan;
use App\Models\FloorItem;

#[Title('Floor Plan Builder')]
class FloorPlanBuilder extends Component implements HasMingles
{
    use InteractsWithMingles;

    public $currentParentId = null;

    public function mount()
    {
        $this->currentParentId = null;
    }

    public function component(): string
    {
        return 'resources/js/mingle/Inventory/FloorPlanBuilder/index.js';
    }

    public function mingleData(): array
    {
        if ($this->currentParentId === null) {
            $plans = FloorPlan::all();
            $items = $plans->map(function($p) {
                return [
                    'id' => 'plan_' . $p->id,
                    'label' => $p->name,
                    'level' => 0,
                    'type' => 'floor_plan',
                    'shape_type' => 'box',
                    'x' => $p->x ?? 40, 'y' => $p->y ?? 40, 
                    'width' => $p->width ?? 200, 'height' => $p->height ?? 150,
                    'config' => ['color' => $p->color ?? '#0f172a'],
                    'points' => null
                ];
            });

            return ['plan' => null, 'items' => $items, 'parentData' => null, 'currentParentId' => null];
        }

        $planId = str_replace('plan_', '', $this->currentParentId); 
        $plan = FloorPlan::find($planId);

        $items = FloorItem::where('parent_id', $this->currentParentId)
                          ->orWhere(function($query) use ($planId) {
                              $query->where('floor_plan_id', $planId)->whereNull('parent_id');
                          })->get();

        $parentData = FloorItem::find($this->currentParentId);

        return [
            'plan' => $plan, 'items' => $items,
            'parentData' => $parentData, 'currentParentId' => $this->currentParentId,
        ];
    }

    public function loadChildren($id, $level)
    {
        if ($level == 0) {
            $this->currentParentId = $id;
            return $this->mingleData();
        }
        if ($level < 4) {
            $this->currentParentId = $id;
        } 
        return $this->mingleData();
    }

    public function goBack()
    {
        if ($this->currentParentId) {
            if (str_starts_with($this->currentParentId, 'plan_')) {
                $this->currentParentId = null;
            } else {
                $parent = FloorItem::find($this->currentParentId);
                $this->currentParentId = $parent ? $parent->parent_id : null;
                if ($this->currentParentId === null && $parent && $parent->floor_plan_id) {
                    $this->currentParentId = 'plan_' . $parent->floor_plan_id;
                }
            }
        }
        return $this->mingleData();
    }

    public function addItem($color = '#3b82f6', $parentId = null, $level = 1, $name = null, $shapeType = 'box', $points = null)
    {
        if ($level == 0) {
            $boxWidth = 200; $boxHeight = 150;
            $newX = (1000 - $boxWidth) / 2;
            $newY = (800 - $boxHeight) / 2;

            FloorPlan::create([
                'name' => $name ?: 'Floor Plan ' . (FloorPlan::count() + 1),
                'grid_width' => 1000, 'grid_height' => 800,
                'x' => $newX, 'y' => $newY, 'width' => $boxWidth, 'height' => $boxHeight,
                'color' => '#0f172a'
            ]);
            return $this->mingleData();
        }

        $planId = null;
        if ($this->currentParentId && str_starts_with($this->currentParentId, 'plan_')) {
            $planId = str_replace('plan_', '', $this->currentParentId);
        } elseif ($parentId) {
            $parentItem = FloorItem::find($parentId);
            $planId = $parentItem ? $parentItem->floor_plan_id : null;
        }
        $plan = FloorPlan::find($planId) ?? FloorPlan::first();
        if (!$plan) return $this->mingleData();

        $labelPrefix = match((int)$level) {
            1 => 'New Area', 2 => 'New Location', 3 => 'New Line', 4 => 'New Item', default => 'New Shape'
        };

        $boxWidth = $level == 4 ? 80 : 120; $boxHeight = $level == 4 ? 80 : 120;
        $newX = (1000 - $boxWidth) / 2; $newY = (800 - $boxHeight) / 2;

        if ($shapeType === 'polygon' && is_array($points) && count($points) > 0) {
            $xs = array_column($points, 'x');
            $ys = array_column($points, 'y');
            $newX = min($xs);
            $newY = min($ys);
            $boxWidth = max($xs) - $newX;
            $boxHeight = max($ys) - $newY;
        } else {
            $shapeType = 'box';
            $isOccupied = true;
            while ($isOccupied) {
                $isOccupied = false;
                $existing = FloorItem::where('floor_plan_id', $plan->id)->where('parent_id', $parentId)->get();
                foreach ($existing as $e) {
                    if (abs($e->x - $newX) < 100 && abs($e->y - $newY) < 100) {
                        $isOccupied = true; $newX += 20; $newY += 20; break;
                    }
                }
            }
        }

        // Posisi default label
        $labelX = $newX;
        $labelY = $newY + 20;
        if ($shapeType === 'polygon' && is_array($points) && count($points) > 0) {
            $labelX = $points[0]['x'];
            $labelY = $points[0]['y'] + 20;
        }

        $type = match((int)$level) {
            1 => 'area', 2 => 'location', 3 => 'line', 4 => 'item', default => 'box'
        };
        $realParentId = ($level == 1) ? null : $parentId;

        FloorItem::create([
            'floor_plan_id' => $plan->id,
            'parent_id' => $realParentId,
            'level' => $level,
            'type' => $type,
            'label' => $labelPrefix,
            'x' => $newX, 'y' => $newY,
            'width' => $boxWidth, 'height' => $boxHeight,
            'shape_type' => $shapeType,
            'points' => $points,
            'config' => [
                'color' => $color, 'link' => '', 'register_number' => '',
                'label_x' => $labelX, 'label_y' => $labelY,
            ]
        ]);

        return $this->mingleData();
    }

    public function updateItemPosition($id, $x, $y)
    {
        if (str_starts_with($id, 'plan_')) {
            FloorPlan::find(str_replace('plan_', '', $id))?->update(['x' => $x, 'y' => $y]);
        } else {
            FloorItem::find($id)?->update(['x' => $x, 'y' => $y]);
        }
    }

    public function updateItemSize($id, $width, $height, $x, $y)
    {
        if (str_starts_with($id, 'plan_')) {
            FloorPlan::find(str_replace('plan_', '', $id))?->update(['width' => $width, 'height' => $height, 'x' => $x, 'y' => $y]);
        } else {
            FloorItem::find($id)?->update(['width' => $width, 'height' => $height, 'x' => $x, 'y' => $y]);
        }
    }

    public function updateItemLabel($id, $label)
    {
        if (str_starts_with($id, 'plan_')) {
            FloorPlan::find(str_replace('plan_', '', $id))?->update(['name' => $label]);
        } else {
            FloorItem::find($id)?->update(['label' => $label]);
        }
    }

    // FUNGSI BARU UNTUK MENYIMPAN POSISI LABEL
    public function updateItemLabelPosition($id, $x, $y)
    {
        if (str_starts_with($id, 'plan_')) return;
        $item = FloorItem::find($id);
        if ($item) {
            $config = $item->config ?? [];
            $config['label_x'] = $x;
            $config['label_y'] = $y;
            $item->update(['config' => $config]);
        }
    }

    public function updateItemLink($id, $link) {
        if (str_starts_with($id, 'plan_')) return;
        $item = FloorItem::find($id);
        if ($item) { $config = $item->config ?? []; $config['link'] = $link; $item->update(['config' => $config]); }
    }

    public function updateItemConfig($id, $levels = 0, $bins = 0, $register_number = null) {
        if (str_starts_with($id, 'plan_')) return;
        $item = FloorItem::find($id);
        if ($item) {
            $config = $item->config ?? [];
            if ($levels > 0) $config['levels'] = (int) $levels;
            if ($bins > 0) $config['bins'] = (int) $bins;
            if ($register_number !== null) $config['register_number'] = $register_number;
            $item->update(['config' => $config]);
        }
    }
}