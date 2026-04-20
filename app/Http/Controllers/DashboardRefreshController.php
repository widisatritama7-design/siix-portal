<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardRefreshController extends Controller
{
    public function refresh(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['success' => false], 400);
        }
        
        $userId = auth()->id();
        $today = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d');
        
        // Get today's page views
        $todayPageViews = DB::table('page_views')
            ->where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->whereNotIn('page', ['livewire', 'livewire/*', 'livewire/update'])
            ->count();
        
        // Get today's sessions
        $todaySessions = DB::table('session_analytics')
            ->where('user_id', $userId)
            ->whereDate('login_at', $today)
            ->count();
        
        // Get page views distribution
        $allSessions = DB::table('session_analytics')
            ->where('user_id', $userId)
            ->whereDate('login_at', $today)
            ->get();
        
        $pageViewsDistribution = [
            '0_5' => 0,
            '5_10' => 0,
            '10_30' => 0,
            '30_60' => 0,
        ];
        
        foreach ($allSessions as $session) {
            $loginTime = Carbon::parse($session->login_at)->setTimezone('Asia/Jakarta');
            $sessionEndTime = $loginTime->copy()->addHours(1);
            
            $sessionPageViews = DB::table('page_views')
                ->where('user_id', $userId)
                ->whereBetween('created_at', [$loginTime, $sessionEndTime])
                ->whereNotIn('page', ['livewire', 'livewire/*', 'livewire/update'])
                ->get();
            
            foreach ($sessionPageViews as $pageView) {
                $viewTime = Carbon::parse($pageView->created_at)->setTimezone('Asia/Jakarta');
                $minutesAfterLogin = $loginTime->diffInMinutes($viewTime);
                
                if ($minutesAfterLogin >= 0 && $minutesAfterLogin < 5) {
                    $pageViewsDistribution['0_5']++;
                } elseif ($minutesAfterLogin >= 5 && $minutesAfterLogin < 10) {
                    $pageViewsDistribution['5_10']++;
                } elseif ($minutesAfterLogin >= 10 && $minutesAfterLogin < 30) {
                    $pageViewsDistribution['10_30']++;
                } elseif ($minutesAfterLogin >= 30 && $minutesAfterLogin <= 60) {
                    $pageViewsDistribution['30_60']++;
                }
            }
        }
        
        $totalPageViewsForDist = array_sum($pageViewsDistribution);
        if ($totalPageViewsForDist == 0) {
            $totalPageViewsForDist = 1;
        }
        
        $percent0_5 = round(($pageViewsDistribution['0_5'] / $totalPageViewsForDist) * 100);
        $percent5_10 = round(($pageViewsDistribution['5_10'] / $totalPageViewsForDist) * 100);
        $percent10_30 = round(($pageViewsDistribution['10_30'] / $totalPageViewsForDist) * 100);
        $percent30_60 = round(($pageViewsDistribution['30_60'] / $totalPageViewsForDist) * 100);
        
        // Adjust percentages to ensure total = 100%
        $totalPercent = $percent0_5 + $percent5_10 + $percent10_30 + $percent30_60;
        if ($totalPercent != 100 && $totalPercent > 0) {
            $diff = 100 - $totalPercent;
            $percentages = [
                '0_5' => &$percent0_5,
                '5_10' => &$percent5_10,
                '10_30' => &$percent10_30,
                '30_60' => &$percent30_60
            ];
            arsort($percentages);
            foreach ($percentages as $key => &$value) {
                $value += $diff;
                break;
            }
        }
        
        // Get top pages
        $topPages = DB::table('page_views')
            ->where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->whereNotIn('page', ['livewire', 'livewire/*', 'livewire/update', 'null'])
            ->whereNotNull('page')
            ->select('page', DB::raw('COUNT(*) as views'))
            ->groupBy('page')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return [
                    'page' => $item->page,
                    'views' => $item->views,
                    'url' => url($item->page)
                ];
            });
        
        return response()->json([
            'success' => true,
            'todayPageViews' => $todayPageViews,
            'todaySessions' => $todaySessions,
            'pageViewsDistribution' => $pageViewsDistribution,
            'percentages' => [
                'percent0_5' => $percent0_5,
                'percent5_10' => $percent5_10,
                'percent10_30' => $percent10_30,
                'percent30_60' => $percent30_60,
            ],
            'topPages' => $topPages
        ]);
    }
}