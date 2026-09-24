<?php

namespace App\Http\Controllers\QAQC;

use App\Http\Controllers\Controller;
use App\Models\QAQC\BlindTest\BlindTest;
use Illuminate\Http\Request;

class BlindTestPrintController extends Controller
{
    public function print(Request $request)
    {
        // Terima filter dari query string
        $dateFrom         = $request->query('dateFrom');
        $dateUntil        = $request->query('dateUntil');
        $yearFilter       = $request->query('yearFilter');
        $monthFilter      = $request->query('monthFilter');
        $departmentFilter = $request->query('departmentFilter');
        $sectionFilter    = $request->query('sectionFilter');

        $records = BlindTest::query()
            ->with(['employee'])
            ->where('status', 'completed')
            ->when($dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when($dateUntil, fn ($q) => $q->whereDate('created_at', '<=', $dateUntil))
            ->when($yearFilter, fn ($q) => $q->whereYear('created_at', $yearFilter))
            ->when($monthFilter, fn ($q) => $q->whereMonth('created_at', $monthFilter))
            ->when($sectionFilter, fn ($q) => $q->where('section', $sectionFilter))
            ->when($departmentFilter, function ($q) use ($departmentFilter) {
                $q->whereHas('employee', fn ($eq) => $eq->where('department', $departmentFilter));
            })
            ->orderByDesc('created_at')
            ->get();

        // ========== AGGREGATE PER-EMPLOYEE (sama dengan Livewire) ==========
        $grouped = $records->groupBy('employee_id')->map(function ($items) {
            // Group by test (section + customer + model) supaya kalau ada 2 test beda tetap dihitung
            $byTest = $items->groupBy(function ($r) {
                return ($r->section ?? '-') . '|' . ($r->customer_id ?? '-') . '|' . ($r->model_id ?? '-');
            });

            $passCount = 0;
            $failCount = 0;

            foreach ($byTest as $sameTest) {
                // Ambil attempt TERAKHIR per test
                $latest = $sameTest->sortByDesc('attempt')->first();
                if (!$latest) continue;

                $answers = $latest->user_answers ?? [];
                if (!is_array($answers)) continue;

                // Hitung langsung per baris
                foreach ($answers as $answer) {
                    if (!empty($answer['is_correct'])) {
                        $passCount++;
                    } else {
                        $failCount++;
                    }
                }
            }

            $totalSoal = $passCount + $failCount;
            $percentage = $totalSoal > 0 ? (int) round(($passCount / $totalSoal) * 100) : 0;
            $roundedPercentage = max(0, min(100, (int) (round($percentage / 20) * 20)));

            $sections = $items->pluck('section')
                ->filter()
                ->map(fn ($s) => trim($s))
                ->unique()
                ->values();

            $latestAttempt = $byTest->map(fn ($group) => $group->max('attempt'))->max() ?? 1;
            $first = $items->first();

            return [
                'nik'                => $first->employee->nik ?? '-',
                'name'               => $first->employee->name ?? '-',
                'department'         => $first->employee->department ?? '-',
                'section'            => $sections->implode(', ') ?: '-',
                'attempt'            => $latestAttempt,
                'max_attempt'        => $first->max_attempt ?? 2,
                'fail_count'         => $failCount,
                'pass_count'         => $passCount,
                'total_soal'         => $totalSoal,
                'percentage'         => $percentage,
                'rounded_percentage' => $roundedPercentage,
            ];
        })->sortBy('name')->values();

        // Distribusi
        $buckets = [0, 20, 40, 60, 80, 100];
        $distribution = array_fill_keys($buckets, 0);
        foreach ($grouped as $item) {
            $distribution[$item['rounded_percentage']]++;
        }

        // Aggregate totals
        $totalSoal  = $grouped->sum('total_soal');
        $totalPass  = $grouped->sum('pass_count');
        $totalFail  = $grouped->sum('fail_count');

        $averagePercentage = $grouped->count() > 0
            ? round($grouped->avg('percentage'), 1)
            : 0;

        $overallPercentage = $totalSoal > 0
            ? round(($totalPass / $totalSoal) * 100, 1)
            : 0;

        // Info filter untuk header
        $filterInfo = [
            'dateFrom'   => $dateFrom,
            'dateUntil'  => $dateUntil,
            'year'       => $yearFilter,
            'month'      => $monthFilter,
            'department' => $departmentFilter,
            'section'    => $sectionFilter,
        ];

        return view('livewire.qaqc.blind-test.print', [
            'data'              => $grouped,
            'distribution'      => $distribution,
            'totalRecords'      => $grouped->count(),
            'totalFail'         => $totalFail,
            'totalPass'         => $totalPass,
            'totalSoal'         => $totalSoal,
            'averagePercentage' => $averagePercentage,
            'overallPercentage' => $overallPercentage,
            'filterInfo'        => $filterInfo,
        ]);
    }
}