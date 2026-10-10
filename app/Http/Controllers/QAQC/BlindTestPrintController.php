<?php

namespace App\Http\Controllers\QAQC;

use App\Http\Controllers\Controller;
use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Deffect;
use Illuminate\Http\Request;

class BlindTestPrintController extends Controller
{
    public function print(Request $request)
    {
        $yearFilter    = $request->query('yearFilter');
        $monthFilter   = $request->query('monthFilter');
        $sectionFilter = $request->query('sectionFilter');

        $records = BlindTest::query()
            ->with(['employee'])
            ->where('status', 'completed')
            ->when($yearFilter,    fn ($q) => $q->whereYear('created_at', $yearFilter))
            ->when($monthFilter,   fn ($q) => $q->whereMonth('created_at', $monthFilter))
            ->when($sectionFilter, fn ($q) => $q->where('section', $sectionFilter))
            ->orderByDesc('created_at')
            ->get();

        // ==================== HELPER: hitung pass per test ====================
        $countPass = function ($answers) {
            if (!is_array($answers)) return 0;

            return collect($answers)
                ->filter(function ($a) {
                    $userAnswer = $a['user_answer'] ?? '';
                    $locStatus  = $a['location_status'] ?? null;
                    if ($userAnswer === 'MISSING') return false;
                    if ($locStatus === 'pending')  return false;
                    return !empty($a['is_correct']);
                })
                ->count();
        };

        // ==================== AGGREGATE PER EMPLOYEE ====================
        $employeeData = $records->groupBy('employee_id')->map(function ($items) use ($countPass) {
            $passCount  = 0;
            $failCount  = 0;
            $totalKunci = 0;
            $latestAttempt = 1;

            foreach ($items as $r) {
                $kunciCount = count($r->blind_test_items ?? []);
                $totalKunci += $kunciCount;

                $passInTest = $countPass($r->user_answers ?? []);
                $passCount += $passInTest;
                $failCount += max(0, $kunciCount - $passInTest);

                if (($r->attempt ?? 1) > $latestAttempt) {
                    $latestAttempt = $r->attempt;
                }
            }

            $totalSoal  = $totalKunci;
            $percentage = $totalSoal > 0 ? (int) round(($passCount / $totalSoal) * 100) : 0;
            $rounded    = max(0, min(100, (int) (round($percentage / 20) * 20)));

            $sections = $items->pluck('section')
                ->filter()
                ->map(fn ($s) => trim($s))
                ->unique()
                ->values();

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
                'rounded_percentage' => $rounded,
            ];
        })->sortBy('name')->values();

        // Distribusi
        $buckets = [0, 20, 40, 60, 80, 100];
        $distribution = array_fill_keys($buckets, 0);
        foreach ($employeeData as $item) {
            $distribution[$item['rounded_percentage']]++;
        }

        $totalSoal  = $employeeData->sum('total_soal');
        $totalPass  = $employeeData->sum('pass_count');
        $totalFail  = $employeeData->sum('fail_count');

        $averagePercentage = $employeeData->count() > 0
            ? round($employeeData->avg('percentage'), 1)
            : 0;

        $overallPercentage = $totalSoal > 0
            ? round(($totalPass / $totalSoal) * 100, 1)
            : 0;

        // ==================== AGGREGATE PER DEFECT (BY ORANG) ====================
        // Hitung PASS langsung dari user_answers (tanpa lookup ke blind_test_items)
        $bucket = [];

        foreach ($records as $bt) {
            $employeeId  = $bt->employee_id;
            $userAnswers = collect($bt->user_answers ?? []);

            foreach ($userAnswers as $ua) {
                $deffectId  = (int) ($ua['deffect_item_id'] ?? 0);
                if ($deffectId <= 0) continue;

                $userAnswer = $ua['user_answer'] ?? '';
                $locStatus  = $ua['location_status'] ?? null;

                if ($userAnswer === 'MISSING') continue;
                if ($locStatus === 'pending')  continue;

                $status = !empty($ua['is_correct']) ? 'pass' : 'fail';

                if (!isset($bucket[$deffectId])) {
                    $bucket[$deffectId] = ['employees' => []];
                }

                if (!isset($bucket[$deffectId]['employees'][$employeeId])) {
                    $bucket[$deffectId]['employees'][$employeeId] = $status;
                } else {
                    if ($status === 'pass') {
                        $bucket[$deffectId]['employees'][$employeeId] = 'pass';
                    }
                }
            }
        }

        $deffectIds = array_keys($bucket);
        $deffects   = Deffect::whereIn('id', $deffectIds)->get()->keyBy('id');

        $defectData = collect($bucket)->map(function ($v, $deffectId) use ($deffects) {
            $totalEmployee = count($v['employees']);
            $pass          = collect($v['employees'])->filter(fn ($s) => $s === 'pass')->count();
            $fail          = $totalEmployee - $pass;

            return [
                'deffect_id'     => $deffectId,
                'deffect_name'   => $deffects[$deffectId]->deffect_item_name
                                        ?? '(Deleted Deffect #'.$deffectId.')',
                'total_employee' => $totalEmployee,
                'pass'           => $pass,
                'fail'           => $fail,
                'total'          => $totalEmployee,
            ];
        })->sortByDesc('total_employee')->values();

        $totalDefectRecords = $defectData->count();

        // Info filter
        $filterInfo = [
            'year'    => $yearFilter,
            'month'   => $monthFilter,
            'section' => $sectionFilter,
        ];

        return view('livewire.qaqc.blind-test.print', [
            // Employee
            'data'              => $employeeData,
            'distribution'      => $distribution,
            'totalRecords'      => $employeeData->count(),
            'totalFail'         => $totalFail,
            'totalPass'         => $totalPass,
            'totalSoal'         => $totalSoal,
            'averagePercentage' => $averagePercentage,
            'overallPercentage' => $overallPercentage,
            // Defect
            'defectData'        => $defectData,
            'totalDefectRecords'=> $totalDefectRecords,
            // Filter
            'filterInfo'        => $filterInfo,
        ]);
    }
}