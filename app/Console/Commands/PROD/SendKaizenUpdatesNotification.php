<?php

namespace App\Console\Commands\PROD;

use App\Mail\PROD\KaizenUpdatesEmail;
use App\Models\PROD\Kaizen\Kaizen;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendKaizenUpdatesNotification extends Command
{
    protected $signature = 'kaizen:send-updates-email';

    protected $description = 'Send email notification for new Kaizen entries this week';

    public function handle()
    {
        $kaizenCount = Kaizen::where('created_at', '>=', now()->startOfWeek())
            ->where('created_at', '<', now()->endOfWeek())
            ->count();

        $url = 'https://portal.siix-ems.co.id/kaizen/kaizens';

        $year = now()->year;
        $month = now()->month;

        $barChartUrl = $this->generateChartImageUrl($year, $month);
        $donutChartUrl = $this->generateKaizenRankChartImageUrl($year);

        // Kirim email hanya sekali dengan semua data
        Mail::to('sek.production01-smt@siix-global.com')->send(
            new KaizenUpdatesEmail($kaizenCount, $url, $barChartUrl, $donutChartUrl)
        );

        if ($kaizenCount > 0) {
            $this->info("Sent email: There were $kaizenCount new Kaizen entries this week.");
        } else {
            $this->info("Sent email: No new Kaizen entries this week.");
        }
    }

    protected function generateChartImageUrl(int $year, int $month): string
    {
        $processes = Kaizen::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select('process')
            ->distinct()
            ->pluck('process')
            ->toArray();

        if (empty($processes)) {
            return 'https://quickchart.io/chart?c=' . urlencode(json_encode([
                'type' => 'bar',
                'data' => [
                    'labels' => ['No Data'],
                    'datasets' => [
                        [
                            'label' => 'Count',
                            'data' => [0],
                            'backgroundColor' => '#d1d5db',
                        ],
                    ],
                ],
                'options' => [
                    'plugins' => [
                        'datalabels' => ['display' => true, 'anchor' => 'end', 'align' => 'end'],
                        'legend' => ['display' => false],
                    ],
                ],
            ]));
        }

        $totalCounts = Kaizen::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->selectRaw('process, count(*) as total')
            ->groupBy('process')
            ->pluck('total', 'process');

        $approvedCounts = Kaizen::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status_kaizen', 'Approved')
            ->selectRaw('process, count(*) as approved_total')
            ->groupBy('process')
            ->pluck('approved_total', 'process');

        $totalData = [];
        $approvedData = [];

        foreach ($processes as $process) {
            $totalData[] = $totalCounts[$process] ?? 0;
            $approvedData[] = $approvedCounts[$process] ?? 0;
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $processes,
                'datasets' => [
                    [
                        'label' => 'Total Process',
                        'backgroundColor' => '#3b82f6',
                        'data' => $totalData,
                    ],
                    [
                        'label' => 'Approved',
                        'backgroundColor' => '#10b981',
                        'data' => $approvedData,
                    ],
                ],
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['position' => 'top'],
                    'datalabels' => [
                        'display' => true,
                        'anchor' => 'end',
                        'align' => 'end',
                        'color' => '#444',
                        'font' => ['weight' => 'bold'],
                    ],
                ],
                'scales' => [
                    'y' => ['beginAtZero' => true],
                ],
                'responsive' => true,
                'maintainAspectRatio' => false,
            ],
        ];

        $chartConfig['plugins'] = ['datalabels'];

        return 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));
    }

    protected function generateKaizenRankChartImageUrl(int $year): string
    {
        $data = Kaizen::query()
            ->whereYear('created_at', $year)
            ->where('status_kaizen', 'approved')  // <- filter status approved
            ->selectRaw('process, COUNT(*) as total')
            ->groupBy('process')
            ->orderByDesc('total')
            ->get();

        $labels = $data->pluck('process')->toArray();
        $series = $data->pluck('total')->toArray();

        if (empty($series)) {
            $labels = ['No Data'];
            $series = [0];
        }

        $chartConfig = [
            'type' => 'doughnut',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $series,
                    'backgroundColor' => [
                        '#3b82f6', '#10b981', '#fbbf24', '#ef4444', '#8b5cf6', '#14b8a6', '#f472b6',
                        '#6b7280', '#f97316', '#22c55e',
                    ],
                ]],
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'labels' => [
                            'color' => '#9ca3af',
                            'font' => ['weight' => '600'],
                        ],
                    ],
                    'datalabels' => [
                        'display' => true,
                        'color' => '#fff',
                        'font' => ['weight' => 'bold'],
                        'formatter' => 'function(value) { return value; }',
                    ],
                ],
            ],
        ];

        $chartConfig['plugins'] = ['datalabels'];

        return 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));
    }

}
