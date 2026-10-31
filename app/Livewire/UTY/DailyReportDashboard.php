<?php

namespace App\Livewire\UTY;

use App\Models\UTY\DailyReportUtility;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;
use Carbon\Carbon;

#[Title('Utility Dashboard')]
class DailyReportDashboard extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $filterMonth;
    public int $filterYear;

    public function mount()
    {
        if (!auth()->user()->can('view daily report utility')) {
            abort(403, 'Unauthorized access.');
        }
        $this->filterMonth = (int) date('m');
        $this->filterYear  = (int) date('Y');
    }

    public function component(): string
    {
        return 'resources/js/mingle/Uty/DailyReportDashboard/index.js';
    }

    public function mingleData(): array
    {
        // Base Query dengan Filter Bulan & Tahun
        $baseQuery = DailyReportUtility::query()
            ->whereMonth('created_at', $this->filterMonth)
            ->whereYear('created_at', $this->filterYear);

        // 1. Hitung Status (Stats Card)
        $statusCounts = (clone $baseQuery)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $stats = [
            'open'              => $statusCounts['Open'] ?? 0,
            'on_progress'       => $statusCounts['On Progress'] ?? 0,
            'under_maintenance' => $statusCounts['Under Maintenance'] ?? 0,
            'closed'            => $statusCounts['Closed'] ?? 0,
            'total'             => array_sum($statusCounts),
        ];

        // 2. Hitung Kategori untuk Tabel (Full Bulan)
        $monthReports = (clone $baseQuery)->get();
        $grouped = $monthReports->groupBy('report_category');
        $totalMonthReports = $monthReports->count();

        // Daftar kategori yang WAJIB selalu muncul
        $allCategories = ['Schedule PM', 'Abnormality', 'Routine Check'];
        $categories = [];

        foreach ($allCategories as $catName) {
            // Ambil data per kategori, kalau kosong kembalikan koleksi kosong
            $items = $grouped->get($catName, collect());
            
            $count = $items->count();
            
            $categories[] = [
                'name' => $catName,
                'open' => $items->where('status', 'Open')->count(),
                'on_progress' => $items->where('status', 'On Progress')->count(),
                'under_maintenance' => $items->where('status', 'Under Maintenance')->count(),
                'closed' => $items->where('status', 'Closed')->count(),
                'total' => $count,
                'percentage' => $totalMonthReports > 0 ? round(($count / $totalMonthReports) * 100, 1) : 0,
            ];
        }

        // 3. Data Chart Bar per Week (Jumat - Kamis)
        $weeksData = [];
        $now = Carbon::now();
        $endOfWeek = $now->copy()->startOfWeek(Carbon::FRIDAY);
        if ($now->dayOfWeek !== Carbon::FRIDAY) {
            $endOfWeek = $now->copy()->previous(Carbon::FRIDAY);
        }
        $endOfWeek->endOfDay();

        for ($i = 5; $i >= 0; $i--) {
            $start = $endOfWeek->copy()->subWeeks($i)->startOfDay();
            $end = $start->copy()->addDays(6)->endOfDay(); 

            if ($start->month == $this->filterMonth || $end->month == $this->filterMonth) {
                $count = (clone $baseQuery)->whereBetween('created_at', [$start, $end])->count();
                $weeksData[] = [
                    'label' => $start->format('d M') . ' - ' . $end->format('d M'),
                    'count' => $count,
                ];
            }
        }

        $years = range(date('Y'), date('Y') - 5);

        return [
            'stats' => $stats,
            'categories' => $categories,
            'chartData' => $weeksData,
            'currentMonth' => $this->filterMonth,
            'currentYear' => $this->filterYear,
            'availableYears' => $years,
        ];
    }

    public function changeFilter(int $month, int $year): array
    {
        $this->filterMonth = $month;
        $this->filterYear  = $year;
        return $this->mingleData();
    }
}