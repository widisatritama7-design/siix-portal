<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EspDevice;
use App\Models\EspDeviceLog;
use Illuminate\Http\Request;

class EspController extends Controller
{
    /**
     * Terima heartbeat dari ESP32
     */
    public function heartbeat(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'device_id' => 'required|string|max:255',
            'status' => 'required|in:connected,disconnected',
            'ip_address' => 'nullable|ip',
            'rssi' => 'nullable|integer|between:-120,0',
            'uptime_seconds' => 'nullable|integer|min:0',
            'lockers' => 'nullable|array',
            'lockers.*.code' => 'required|string',
            'lockers.*.is_open' => 'required|boolean'
        ]);

        // Cari atau buat device
        $device = EspDevice::updateOrCreate(
            ['device_id' => $validated['device_id']],
            [
                'name' => $validated['device_id'],
                'status' => $validated['status'],
                'ip_address' => $validated['ip_address'] ?? null,
                'rssi' => $validated['rssi'] ?? null,
                'uptime_seconds' => $validated['uptime_seconds'] ?? null,
                'last_seen_at' => now(),
                'locker_data' => $validated['lockers'] ?? []
            ]
        );

        // Jika ada perubahan status, buat log
        if ($device->wasChanged('status')) {
            EspDeviceLog::create([
                'esp_device_id' => $device->id,
                'status' => $validated['status'],
                'rssi' => $validated['rssi'] ?? null,
                'locker_data' => $validated['lockers'] ?? []
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Heartbeat received',
            'data' => [
                'device_id' => $device->device_id,
                'status' => $device->status,
                'last_seen_at' => $device->last_seen_at
            ]
        ]);
    }

    /**
     * Ambil status semua device
     */
    public function index()
    {
        $devices = EspDevice::all()->map(function ($device) {
            return [
                'id' => $device->id,
                'device_id' => $device->device_id,
                'name' => $device->name,
                'status' => $device->status,
                'is_online' => $device->is_online,
                'ip_address' => $device->ip_address,
                'rssi' => $device->rssi,
                'uptime' => $device->uptime_human,
                'last_seen_at' => $device->last_seen_at,
                'lockers' => $device->lockers
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }

    /**
     * Ambil detail satu device
     */
    public function show($deviceId)
    {
        $device = EspDevice::where('device_id', $deviceId)->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $device->id,
                'device_id' => $device->device_id,
                'name' => $device->name,
                'status' => $device->status,
                'is_online' => $device->is_online,
                'ip_address' => $device->ip_address,
                'rssi' => $device->rssi,
                'uptime' => $device->uptime_human,
                'uptime_seconds' => $device->uptime_seconds,
                'last_seen_at' => $device->last_seen_at,
                'lockers' => $device->lockers
            ]
        ]);
    }

    /**
     * Ambil log history device
     */
    public function logs($deviceId, Request $request)
    {
        $device = EspDevice::where('device_id', $deviceId)->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        $limit = $request->input('limit', 50);
        $logs = $device->logs()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($log) {
                return [
                    'status' => $log->status,
                    'rssi' => $log->rssi,
                    'lockers' => $log->locker_data,
                    'created_at' => $log->created_at
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }
}