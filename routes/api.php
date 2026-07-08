<?php

use App\Http\Controllers\PROD\FCT\ScanPcbController;
use Illuminate\Support\Facades\Route;

// ==================== API ROUTES ====================
Route::prefix('api')->group(function () {
    // Check system lock status
    Route::get('/check-system-lock', [ScanPcbController::class, 'checkSystemLock']);
    
    // Recent scans by process
    Route::get('/recent-scans/{process}', [ScanPcbController::class, 'getRecentScans']);
    
    // Today stats by process
    Route::get('/today-stats/{process}', [ScanPcbController::class, 'getTodayStats']);
    
    // Visual inspection stats
    Route::get('/visual-inspection-stats', [ScanPcbController::class, 'getVisualStats']);
    
    // Dashboard stats
    Route::get('/dashboard-stats', [ScanPcbController::class, 'getDashboardStats']);
});