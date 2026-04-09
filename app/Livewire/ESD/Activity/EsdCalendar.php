<?php

namespace App\Livewire\ESD\Activity;

use App\Models\ESD\EG\EquipmentGroundDetail;
use App\Models\ESD\Flooring\FlooringDetail;
use App\Models\ESD\Garment\GarmentDetail;
use App\Models\ESD\GB\GroundMonitorBoxDetail;
use App\Models\ESD\Glove\GloveDetail;
use App\Models\ESD\Insulatif\InsulatifCheck;
use App\Models\ESD\Ionizer\IonizerDetail;
use App\Models\ESD\Jig\JigDetail;
use App\Models\ESD\Magazine\MagazineDetail;
use App\Models\ESD\Packaging\PackagingDetail;
use App\Models\ESD\Patrol\Patrol;
use App\Models\ESD\Shower\ShowerDetail;
use App\Models\ESD\Soldering\SolderingDetail;
use App\Models\ESD\Worksurface\WorksurfaceDetail;
use App\Models\ESD\WS\WristStrap;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EsdCalendar extends Component
{
    // Per card data
    public $events = [];           // events per type per month
    public $loadedMonths = [];     // track month yang sudah di-load per type
    public $currentMonth = [];     // bulan aktif per card
    public $currentYear = [];      // tahun aktif per card
    public $selectedDate = [];     // selected date per card

    protected $modelMap = [
        'equipment' => [EquipmentGroundDetail::class, 'equipmentGround', 'machine_name', 'equipment_ground_id'],
        'flooring' => [FlooringDetail::class, 'flooring', 'register_no', 'flooring_id'],
        'garment' => [GarmentDetail::class, 'garment', 'name', 'nik'],
        'glove' => [GloveDetail::class, 'glove', 'sap_code', 'glove_id'],
        'groundmonitorbox' => [GroundMonitorBoxDetail::class, 'groundMonitorBox', 'register_no', 'ground_monitor_box_id'],
        'ionizer' => [IonizerDetail::class, 'ionizer', 'register_no', 'ionizer_id'],
        'jig' => [JigDetail::class, 'jig', 'register_no', 'jigs_id'],
        'magazine' => [MagazineDetail::class, 'magazine', 'register_no', 'magazines_id'],
        'packaging' => [PackagingDetail::class, 'packaging', 'sap_code', 'packaging_id'],
        'soldering' => [SolderingDetail::class, 'soldering', 'register_no', 'soldering_id'],
        'worksurface' => [WorksurfaceDetail::class, 'worksurface', 'register_no', 'worksurface_id'],
        'insulatif' => [InsulatifCheck::class, null, 'register_no', 'register_no'],
        'patrol' => [Patrol::class, null, 'location', 'location'],
        'shower' => [ShowerDetail::class, 'shower', 'register_no', 'shower_id'],
        'wriststrap' => [WristStrap::class, null, 'register_no', 'register_no'],
    ];

    public $typeCodes = [
        'flooring' => 'QR-ADM-24-K049',
        'worksurface' => 'QR-ADM-24-K055',
        'groundmonitorbox' => 'QR-ADM-24-K050',
        'ionizer' => 'QR-ADM-24-K048',
        'equipment' => 'QR-ADM-24-K047',
        'garment' => 'QR-ADM-24-K061',
        'soldering' => 'QR-ADM-24-K054',
        'jig' => 'QR-ADM-24-K056',
        'magazine' => '-',
        'glove' => '-',
        'packaging' => 'QR-ADM-24-K052',
        'insulatif' => '-',
        'patrol' => '-',
        'shower' => '-',
        'wriststrap' => '-'
    ];

    public $displayNames = [
        'equipment' => 'Equipment Grounding',
        'flooring' => 'Flooring',
        'garment' => 'Garment',
        'glove' => 'Glove',
        'groundmonitorbox' => 'Ground Monitor Box',
        'ionizer' => 'Ionizer',
        'jig' => 'Jigs',
        'magazine' => 'Magazine',
        'packaging' => 'Packaging',
        'soldering' => 'Soldering',
        'worksurface' => 'Worksurface',
        'insulatif' => 'Insulatif Check',
        'patrol' => 'Patrol',
        'shower' => 'Shower',
        'wriststrap' => 'Wrist Strap'
    ];

    public $slugMap = [
        'equipment' => 'equipment-grounds',
        'flooring' => 'floorings',
        'garment' => 'garments',
        'glove' => 'gloves',
        'groundmonitorbox' => 'ground-monitor-boxs',
        'ionizer' => 'ionizers',
        'jig' => 'jigs',
        'magazine' => 'magazines',
        'packaging' => 'packagings',
        'soldering' => 'solderings',
        'worksurface' => 'worksurfaces',
        'insulatif' => 'insulatifs',
        'patrol' => 'patrols',
        'shower' => 'showers',
        'wriststrap' => 'wrist-straps'
    ];

    public function mount()
    {
        $types = array_keys($this->modelMap);
        $today = Carbon::now()->format('Y-m-d');
        
        foreach ($types as $type) {
            $this->currentMonth[$type] = Carbon::now()->month;
            $this->currentYear[$type] = Carbon::now()->year;
            $this->selectedDate[$type] = $today;
            $this->events[$type] = [];
            $this->loadedMonths[$type] = [];
        }
    }

    // Refresh all cards (hapus semua cache dan reload)
    public function refreshAllCards()
    {
        // Reset semua loaded months
        $types = array_keys($this->modelMap);
        
        foreach ($types as $type) {
            // Reset loaded months untuk setiap type
            $this->loadedMonths[$type] = [];
            
            // Reload bulan saat ini
            $this->loadCardMonth($type);
        }
    }

    // Get detail URL berdasarkan type dan id
    public function getDetailUrl($type, $id)
    {
        $slug = $this->slugMap[$type] ?? null;
        
        if (!$slug) {
            return '#';
        }
        
        // Khusus untuk insulatif, patrol, wriststrap
        if (in_array($type, ['insulatif', 'patrol', 'wriststrap'])) {
            return "/esd/{$slug}?id={$id}";
        }
        
        // Untuk yang lainnya
        return "/esd/{$slug}/{$id}";
    }

    // Load data untuk satu card di bulan aktifnya
    public function loadCardMonth($type)
    {
        $year = $this->currentYear[$type];
        $month = $this->currentMonth[$type];
        $monthKey = "{$year}-{$month}";
        
        // Cek udah di-load belum
        if (isset($this->loadedMonths[$type][$monthKey]) && $this->loadedMonths[$type][$monthKey]) {
            return;
        }
        
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        
        $events = $this->getEventsForMonth($type, $startDate, $endDate);
        
        $this->events[$type][$monthKey] = $events;
        $this->loadedMonths[$type][$monthKey] = true;
    }

    public function refreshCardMonth($type)
    {
        $year = $this->currentYear[$type];
        $month = $this->currentMonth[$type];
        $monthKey = "{$year}-{$month}";
        
        // HAPUS CACHE bulan ini
        unset($this->loadedMonths[$type][$monthKey]);
        
        // RELOAD data dari database
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        
        $events = $this->getEventsForMonth($type, $startDate, $endDate);
        
        $this->events[$type][$monthKey] = $events;
        $this->loadedMonths[$type][$monthKey] = true;
    }

    protected function getEventsForMonth($type, $startDate, $endDate)
    {
        if (!isset($this->modelMap[$type])) {
            return [];
        }

        [$modelClass, $relation, $field, $foreignKey] = $this->modelMap[$type];

        if (!class_exists($modelClass)) {
            return [];
        }

        try {
            if ($relation) {
                $items = $modelClass::with($relation)
                    ->whereNotNull('next_date')
                    ->whereBetween('next_date', [$startDate, $endDate])
                    ->get(['id', $foreignKey, 'created_at', 'next_date', 'remarks']);
                
                $items = $items->filter(fn($item) => $item->{$relation} !== null);
            } else {
                $items = $modelClass::whereNotNull('next_date')
                    ->whereBetween('next_date', [$startDate, $endDate])
                    ->get(['id', $foreignKey, 'created_at', 'next_date', 'remarks']);
            }

            $events = $items->map(function ($item) use ($relation, $field, $modelClass, $foreignKey, $type) {
                $date = $item->next_date instanceof \Illuminate\Support\Carbon
                    ? $item->next_date->format('Y-m-d')
                    : date('Y-m-d', strtotime($item->next_date));

                if ($relation && $item->{$relation}) {
                    $related = $item->{$relation};
                    $title = $related->{$field} ?? '(No Title)';
                    $masterId = $related->id ?? null;
                } else {
                    $title = $item->{$field} ?? '(No Title)';
                    $masterId = $item->{$foreignKey};
                }

                $copyItem = $modelClass::whereDate('created_at', $date)
                    ->where($foreignKey, $item->{$foreignKey})
                    ->first();

                $remarks = optional($copyItem)->remarks;
                $hasRemarksProblem = in_array(strtolower(trim((string)$remarks)), ['schedule on', 'delay']);
                $hasActual = $copyItem && !$hasRemarksProblem;

                return [
                    'date' => $date,
                    'title' => $title,
                    'master_id' => $masterId,
                    'hasActual' => $hasActual,
                    'detail_foreign_key' => $item->{$foreignKey},
                    'remarks' => $hasRemarksProblem ? $remarks : null,
                ];
            })->values();

            return $events;
        } catch (\Exception $e) {
            Log::error("Error loading events for {$type}: " . $e->getMessage());
            return [];
        }
    }

    // Navigasi Prev untuk satu card
    public function goToPrevMonth($type)
    {
        $date = Carbon::create($this->currentYear[$type], $this->currentMonth[$type], 1)->subMonth();
        $this->currentMonth[$type] = $date->month;
        $this->currentYear[$type] = $date->year;
        
        // Hapus cache bulan lama biar bisa reload
        $oldMonthKey = "{$date->year}-{$date->month}";
        if (isset($this->loadedMonths[$type][$oldMonthKey])) {
            unset($this->loadedMonths[$type][$oldMonthKey]);
        }
        
        $this->loadCardMonth($type);
    }

    // Navigasi Next untuk satu card
    public function goToNextMonth($type)
    {
        $date = Carbon::create($this->currentYear[$type], $this->currentMonth[$type], 1)->addMonth();
        $this->currentMonth[$type] = $date->month;
        $this->currentYear[$type] = $date->year;
        
        // Hapus cache bulan lama biar bisa reload
        $oldMonthKey = "{$date->year}-{$date->month}";
        if (isset($this->loadedMonths[$type][$oldMonthKey])) {
            unset($this->loadedMonths[$type][$oldMonthKey]);
        }
        
        $this->loadCardMonth($type);
    }

    // Select date untuk satu card
    public function selectDate($type, $date)
    {
        $this->selectedDate[$type] = $date;
    }

    // Get calendar weeks untuk satu card
    public function getCalendarWeeks($type)
    {
        $year = $this->currentYear[$type];
        $month = $this->currentMonth[$type];
        
        $firstDayOfMonth = Carbon::create($year, $month, 1);
        $daysInMonth = $firstDayOfMonth->daysInMonth;
        $startDayOfWeek = $firstDayOfMonth->dayOfWeek;
        
        $weeks = [];
        $currentDay = 1;
        
        for ($week = 0; $week < 6; $week++) {
            $weekDays = [];
            for ($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++) {
                if ($week === 0 && $dayOfWeek < $startDayOfWeek) {
                    $weekDays[] = null;
                } elseif ($currentDay > $daysInMonth) {
                    $weekDays[] = null;
                } else {
                    $date = Carbon::create($year, $month, $currentDay)->format('Y-m-d');
                    
                    $weekDays[] = [
                        'day' => $currentDay,
                        'date' => $date,
                        'isSelected' => $date === ($this->selectedDate[$type] ?? ''),
                    ];
                    $currentDay++;
                }
            }
            $weeks[] = $weekDays;
            if ($currentDay > $daysInMonth) break;
        }
        
        return $weeks;
    }

    // Get events untuk satu card di satu tanggal
    public function getEventsForDate($type, $date)
    {
        $dateObj = Carbon::parse($date);
        $monthKey = "{$dateObj->year}-{$dateObj->month}";
        
        if (!isset($this->events[$type][$monthKey])) {
            return [];
        }
        
        return collect($this->events[$type][$monthKey])
            ->filter(fn($event) => $event['date'] === $date)
            ->values()
            ->toArray();
    }

    // Hitung event count untuk satu card di satu tanggal
    public function getEventCount($type, $date)
    {
        $dateObj = Carbon::parse($date);
        $monthKey = "{$dateObj->year}-{$dateObj->month}";
        
        if (!isset($this->events[$type][$monthKey])) {
            return 0;
        }
        
        return collect($this->events[$type][$monthKey])
            ->filter(fn($event) => $event['date'] === $date)
            ->count();
    }

    // Dapatkan badge color untuk satu card di satu tanggal
    public function getBadgeColor($type, $date)
    {
        $dateObj = Carbon::parse($date);
        $monthKey = "{$dateObj->year}-{$dateObj->month}";
        
        if (!isset($this->events[$type][$monthKey])) {
            return null;
        }
        
        $events = collect($this->events[$type][$monthKey])
            ->filter(fn($event) => $event['date'] === $date);
        
        if ($events->isEmpty()) {
            return null;
        }
        
        $hasRed = $events->contains(fn($e) => !$e['hasActual']);
        $allGreen = $events->every(fn($e) => $e['hasActual']);
        
        if ($allGreen) return 'green';
        if ($hasRed) return 'red';
        return 'yellow';
    }

    // Get month name untuk satu card
    public function getMonthName($type)
    {
        return Carbon::create($this->currentYear[$type], $this->currentMonth[$type], 1)->format('F Y');
    }

    // Get formatted selected date untuk satu card
    public function getSelectedDateFormatted($type)
    {
        $date = $this->selectedDate[$type] ?? Carbon::now()->format('Y-m-d');
        return Carbon::parse($date)->format('d M Y');
    }

    public function getSortedTypesProperty()
    {
        $types = array_keys($this->modelMap);
        
        return collect($types)
            ->filter(fn($type) => ($this->typeCodes[$type] ?? '-') !== '-')
            ->sortBy(fn($type) => intval(explode('-K', $this->typeCodes[$type] ?? '0')[1] ?? 0))
            ->values()
            ->concat(collect($types)->filter(fn($type) => ($this->typeCodes[$type] ?? '-') === '-'))
            ->toArray();
    }

    public function render()
    {
        return view('livewire.esd.activity.esd-calendar', [
            'sortedTypes' => $this->sortedTypes,
        ]);
    }
}