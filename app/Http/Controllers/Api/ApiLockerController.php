<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ESD\Locker\Locker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiLockerController extends Controller
{
    /**
     * ESP32 membaca status semua loker
     * GET /lockers/status
     * Response: hanya kirim code dan should_open (true/false)
     */
    public function getStatus()
    {
        $lockers = Locker::select('code', 'status', 'locked_until')
            ->get()
            ->map(function ($locker) {
                return [
                    'code' => $locker->code,
                    'should_open' => $locker->shouldBeOpen(), // true/false saja
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $lockers
        ]);
    }

    /**
     * ESP32 melaporkan bahwa loker sudah terbuka
     * GET/POST /lockers/open?code=ESD001
     */
    public function reportOpen(Request $request, $code = null)
    {
        $code = $code ?? $request->input('code') ?? $request->query('code');
        
        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Code parameter is required'
            ], 400);
        }

        $locker = Locker::where('code', $code)->first();
        
        if (!$locker) {
            return response()->json([
                'success' => false,
                'message' => "Locker '{$code}' not found"
            ], 404);
        }
        
        $locker->setOpen();

        Log::info('Locker OPEN by ESP32', ['code' => $locker->code]);

        return response()->json([
            'success' => true,
            'message' => "Locker {$locker->code} is OPEN",
            'data' => [
                'code' => $locker->code,
                'is_open' => $locker->is_open
            ]
        ]);
    }

    /**
     * ESP32 melaporkan bahwa loker sudah tertutup
     * GET/POST /lockers/close?code=ESD001
     */
    public function reportClose(Request $request, $code = null)
    {
        $code = $code ?? $request->input('code') ?? $request->query('code');
        
        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Code parameter is required'
            ], 400);
        }

        $locker = Locker::where('code', $code)->first();
        
        if (!$locker) {
            return response()->json([
                'success' => false,
                'message' => "Locker '{$code}' not found"
            ], 404);
        }
        
        $locker->setClosed();

        Log::info('Locker CLOSED by ESP32', ['code' => $locker->code]);

        return response()->json([
            'success' => true,
            'message' => "Locker {$locker->code} is CLOSED",
            'data' => [
                'code' => $locker->code,
                'is_open' => $locker->is_open
            ]
        ]);
    }

    /**
     * Ping untuk cek koneksi ESP32
     * GET /lockers/ping
     */
    public function ping()
    {
        return response()->json([
            'success' => true,
            'message' => 'pong',
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}