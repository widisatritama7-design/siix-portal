<?php

namespace App\Livewire\MTC\Dashboard;

use App\Models\MTC\Master\MasterLine;
use Livewire\Component;

class DailyDashboard extends Component
{
    public $pollingInterval = 10000; // 10 seconds

    public function getMasterLinesProperty()
    {
        return MasterLine::with([
                'location',
                'employee',
                'dailyFujis' => fn($q) => $q->latest()->limit(1)->with(['updater', 'approvedBy']),
                'dailyPanasonics' => fn($q) => $q->latest()->limit(1)->with(['updater', 'approvedBy']),
            ])
            ->where(function($q) {
                $q->whereHas('dailyFujis')->orWhereHas('dailyPanasonics');
            })
            ->orderBy('line_number', 'asc')
            ->get()
            ->map(function($line) {
                $fujiChecks = $line->dailyFujis ?? collect();
                $panasonicChecks = $line->dailyPanasonics ?? collect();
                
                $latestFuji = $fujiChecks->first();
                $latestPanasonic = $panasonicChecks->first();
                
                if ($latestFuji || $latestPanasonic) {
                    $latest = $latestFuji ?: $latestPanasonic;
                    $line->daily_check_status = $latest->status ?? 'No Check';
                    $line->daily_check_approval = $latest->approval ?? 'Pending';
                    $line->daily_check_group = $latest->group ?? '-';
                    $line->daily_check_by = $latest->updater?->name ?? '-';
                    $line->daily_approved_by = $latest->approvedBy?->name ?? '-';
                    $line->last_check_time = $latest->updated_at;
                } else {
                    $line->daily_check_status = 'No Check';
                    $line->daily_check_approval = 'No Check';
                    $line->daily_check_group = '-';
                    $line->daily_check_by = '-';
                    $line->daily_approved_by = '-';
                    $line->last_check_time = null;
                }
                
                return $line;
            });
    }

    public function getStats()
    {
        $lines = $this->masterLines;
        
        return [
            'checked' => $lines->where('daily_check_status', 'Checked')->count(),
            'on_progress' => $lines->where('daily_check_status', 'On Progress')->count(),
            'delay' => $lines->where('daily_check_status', 'Delay')->count(),
            'approved' => $lines->where('daily_check_approval', 'Approved')->count(),
            'pending' => $lines->where('daily_check_approval', 'Pending')->count(),
        ];
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'Running' => 'bg-green-100 text-green-800',
            'Maintenance' => 'bg-red-100 text-red-800',
            'Trouble' => 'bg-yellow-100 text-yellow-800',
            'No Schedule' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getDailyCheckColor($status)
    {
        return match($status) {
            'Checked' => 'bg-green-100 text-green-800',
            'On Progress' => 'bg-yellow-100 text-yellow-800',
            'Delay' => 'bg-red-100 text-red-800',
            'No Check' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getApprovalColor($approval)
    {
        return match($approval) {
            'Approved' => 'bg-green-100 text-green-800',
            'Rejected' => 'bg-red-100 text-red-800',
            'Pending' => 'bg-yellow-100 text-yellow-800',
            'No Check' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function render()
    {
        return view('livewire.mtc.dashboard.daily-dashboard', [
            'masterLines' => $this->masterLines,
            'stats' => $this->getStats(),
        ]);
    }
}