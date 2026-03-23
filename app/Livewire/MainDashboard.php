<?php
// app/Livewire/MainDashboard.php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MainDashboard extends Component
{
    public $activeNow = 0;
    public $todayLogins = 0;
    public $avgSessionMinutes = 0;
    public $uniqueVisitors = 0;
    public $activityData = [];
    public $hours = [];
    public $maxActivity = 1;
    public $activities = [];
    public $lt5minPercent = 0;
    public $lt15minPercent = 0;
    public $lt30minPercent = 0;
    public $gt30minPercent = 0;
    public $currentTime = '';
    
    protected function getListeners()
    {
        return [
            'refreshDashboard' => 'refreshData',
            'echo:dashboard,user.activity.updated' => 'handleUserActivity'
        ];
    }
    
    public function mount()
    {
        $this->refreshData();
    }
    
    public function handleUserActivity($payload)
    {
        // Handle real-time update when user login/logout
        $this->refreshData();
        
        // Optional: Show toast notification
        $this->dispatch('notify', [
            'type' => 'info',
            'message' => $payload['user'] . ' ' . $payload['type'] . 'ed'
        ]);
    }
    
    public function refreshData()
    {
        $this->currentTime = now()->format('H:00');
        $this->loadStats();
        $this->loadActivityChart();
        $this->loadRecentActivities();
        $this->loadSessionStats();
    }
    
    private function loadStats()
    {
        // Active now (sessions in last 5 minutes)
        $this->activeNow = DB::table('sessions')
            ->where('last_activity', '>=', now()->subMinutes(5)->getTimestamp())
            ->count();
        
        // Today's logins (from user_activities)
        $this->todayLogins = DB::table('user_activities')
            ->whereDate('created_at', today())
            ->where('action', 'login')
            ->count();
        
        // Average session duration
        $avgSeconds = DB::table('session_analytics')
            ->whereDate('login_at', today())
            ->whereNotNull('duration_seconds')
            ->avg('duration_seconds');
        
        $this->avgSessionMinutes = $avgSeconds ? round($avgSeconds / 60, 1) : 0;
        
        // Unique visitors today
        $this->uniqueVisitors = DB::table('sessions')
            ->whereDate('last_activity', today())
            ->distinct('user_id')
            ->count('user_id');
    }
    
    private function loadActivityChart()
    {
        $this->hours = [];
        $this->activityData = [];
        
        for ($hour = 0; $hour <= 23; $hour++) {
            $this->hours[] = $hour . ':00';
            
            $start = now()->setTime($hour, 0, 0);
            $end = now()->setTime($hour, 59, 59);
            
            // Count unique active users per hour from sessions
            $count = DB::table('sessions')
                ->whereBetween('last_activity', [
                    $start->timestamp,
                    $end->timestamp
                ])
                ->distinct('user_id')
                ->count('user_id');
            
            $this->activityData[] = $count;
        }
        
        $this->maxActivity = !empty($this->activityData) ? max($this->activityData) : 1;
    }
    
    private function loadRecentActivities()
    {
        // Get recent user activities from user_activities table
        $recentActivities = DB::table('user_activities')
            ->join('users', 'user_activities.user_id', '=', 'users.id')
            ->select('users.name as user', 'user_activities.action', 'user_activities.description', 'user_activities.created_at')
            ->orderBy('user_activities.created_at', 'desc')
            ->limit(10)
            ->get();
        
        $this->activities = [];
        foreach ($recentActivities as $activity) {
            $this->activities[] = (object)[
                'user' => $activity->user,
                'action' => $activity->description ?? ucfirst($activity->action),
                'time' => Carbon::parse($activity->created_at),
                'type' => $activity->action
            ];
        }
    }
    
    private function loadSessionStats()
    {
        $totalActiveSessions = DB::table('sessions')->count();
        $totalActiveSessions = $totalActiveSessions ?: 1;
        
        $now = now()->timestamp;
        
        $lt5min = DB::table('sessions')
            ->where('last_activity', '>=', $now - 300)
            ->count();
        $this->lt5minPercent = round(($lt5min / $totalActiveSessions) * 100);
        
        $lt15min = DB::table('sessions')
            ->whereBetween('last_activity', [$now - 900, $now - 300])
            ->count();
        $this->lt15minPercent = round(($lt15min / $totalActiveSessions) * 100);
        
        $lt30min = DB::table('sessions')
            ->whereBetween('last_activity', [$now - 1800, $now - 900])
            ->count();
        $this->lt30minPercent = round(($lt30min / $totalActiveSessions) * 100);
        
        $gt30min = DB::table('sessions')
            ->where('last_activity', '<', $now - 1800)
            ->count();
        $this->gt30minPercent = round(($gt30min / $totalActiveSessions) * 100);
    }
    
    public function render()
    {
        return view('home.dashboard');
    }
}