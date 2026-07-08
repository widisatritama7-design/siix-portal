<?php

namespace App\Http\Controllers\PROD\FCT;

use App\Http\Controllers\Controller;
use App\Models\PROD\FCT\NGBox;
use App\Models\PROD\FCT\PCB;
use App\Models\PROD\FCT\ScanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScanPcbController extends Controller
{
    public function index()
    {
        $isSystemLocked = NGBox::where('is_locked', true)->exists();
        return view('livewire.prod.fct.scan.index', compact('isSystemLocked'));
    }

    public function scanFCT()
    {
        $isSystemLocked = NGBox::where('is_locked', true)->exists();
        return view('livewire.prod.fct.scan.fct', compact('isSystemLocked'));
    }

    public function scanLEDTest()
    {
        $isSystemLocked = NGBox::where('is_locked', true)->exists();
        return view('livewire.prod.fct.scan.led-test', compact('isSystemLocked'));
    }

    public function scanVisualInspection()
    {
        $isSystemLocked = NGBox::where('is_locked', true)->exists();
        return view('livewire.prod.fct.scan.visual-inspection', compact('isSystemLocked'));
    }

    public function processScan(Request $request, $process)
    {
        $request->validate([
            'serial_number' => 'required|string|max:255'
        ]);

        // VALIDASI: Proses yang diizinkan
        $allowedProcesses = ['fct', 'led_test', 'visual_inspection'];
        if (!in_array($process, $allowedProcesses)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid process: ' . $process
            ], 400);
        }

        $serialNumber = trim($request->serial_number);

        if (empty($serialNumber)) {
            return response()->json([
                'success' => false,
                'message' => 'Serial number cannot be empty'
            ], 400);
        }

        DB::beginTransaction();

        try {
            // CEK 1: Apakah ada BOX NG yang terkunci?
            $activeNG = NGBox::where('is_locked', true)->first();
            if ($activeNG) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ SYSTEM LOCKED: There is an active NG Box. Please ask leader to unlock.',
                    'system_locked' => true,
                    'redirect' => route('pcb-scan.leader.index')
                ]);
            }

            // CEK: Apakah ada PCB dengan serial number yang sama yang sudah COMPLETED?
            $existingCompletedPCB = PCB::where('serial_number', $serialNumber)
                                    ->where('status', 'completed')
                                    ->first();
            
            if ($existingCompletedPCB) {
                // Jika sudah complete, buat PCB baru (data lama tetap aman)
                $pcb = PCB::create([
                    'serial_number' => $serialNumber,
                    'status' => 'pending',
                    'current_process' => null,
                    'fct_completed' => false,
                    'led_test_completed' => false,
                    'visual_inspection_completed' => false
                ]);
            } else {
                // CARI PCB yang belum complete
                $pcb = PCB::where('serial_number', $serialNumber)
                        ->where('status', '!=', 'completed')
                        ->first();
                
                if (!$pcb) {
                    // Buat PCB baru jika belum ada
                    $pcb = PCB::create([
                        'serial_number' => $serialNumber,
                        'status' => 'pending',
                        'current_process' => null,
                        'fct_completed' => false,
                        'led_test_completed' => false,
                        'visual_inspection_completed' => false
                    ]);
                }
            }

            // CEK 2: Validasi urutan proses
            $canProceed = true;
            $errorMessage = '';

            switch ($process) {
                case 'fct':
                    if ($pcb->fct_completed) {
                        $canProceed = false;
                        $errorMessage = 'PCB has already completed FCT process';
                    }
                    break;
                    
                case 'led_test':
                    if (!$pcb->fct_completed) {
                        $canProceed = false;
                        $errorMessage = 'PCB must complete FCT process first before LED Test';
                    } elseif ($pcb->led_test_completed) {
                        $canProceed = false;
                        $errorMessage = 'PCB has already completed LED Test process';
                    }
                    break;
                    
                case 'visual_inspection':
                    if (!$pcb->fct_completed) {
                        $canProceed = false;
                        $errorMessage = 'PCB must complete FCT process first before Visual Inspection';
                    } elseif (!$pcb->led_test_completed) {
                        $canProceed = false;
                        $errorMessage = 'PCB must complete LED Test process first before Visual Inspection';
                    } elseif ($pcb->visual_inspection_completed) {
                        $canProceed = false;
                        $errorMessage = 'PCB has already completed Visual Inspection process';
                    }
                    break;
                
                default:
                    $canProceed = false;
                    $errorMessage = 'Invalid process';
            }

            // CEK 3: Jika tidak bisa proceed - Masuk NG Box
            if (!$canProceed) {
                // Generate random 6-digit code
                do {
                    $unlockCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                } while (NGBox::where('unlock_code', $unlockCode)->exists());
                
                // PASTIKAN PCB ID ada sebelum insert ke NGBox
                if (!$pcb->id) {
                    $pcb->save();
                }
                
                // Simpan ke BOX NG
                NGBox::create([
                    'serial_number' => $serialNumber,
                    'pcb_id' => $pcb->id,
                    'blocked_at_process' => $process,
                    'is_locked' => true,
                    'unlock_code' => $unlockCode,
                    'locked_at' => now()
                ]);

                // Update PCB status
                $pcb->status = 'blocked';
                $pcb->save();

                // Simpan log
                ScanLog::create([
                    'serial_number' => $serialNumber,
                    'pcb_id' => $pcb->id,
                    'process' => $process,
                    'result' => 'ng',
                    'box_type' => 'NG',
                    'notes' => $errorMessage
                ]);

                DB::commit();

                return response()->json([
                    'success' => false,
                    'message' => '❌ ' . $errorMessage . '. PCB sent to NG Box.',
                    'ng_box' => true,
                    'system_locked' => true,
                    'unlock_code' => $unlockCode,
                    'redirect' => route('pcb-scan.leader.index')
                ]);
            }

            // CEK 4: Proses normal - OK
            if ($process === 'fct') {
                $pcb->fct_completed = true;
                $pcb->fct_completed_at = now();
            } elseif ($process === 'led_test') {
                $pcb->led_test_completed = true;
                $pcb->led_test_completed_at = now();
            } elseif ($process === 'visual_inspection') {
                $pcb->visual_inspection_completed = true;
                $pcb->visual_inspection_completed_at = now();
            }
            
            $pcb->current_process = $process;
            
            // Cek apakah semua proses sudah selesai
            if ($pcb->fct_completed && $pcb->led_test_completed && $pcb->visual_inspection_completed) {
                $pcb->status = 'completed';
                $pcb->current_process = 'completed';
            } else {
                $pcb->status = 'in_progress';
            }
            
            $pcb->save();

            // Simpan log
            ScanLog::create([
                'serial_number' => $serialNumber,
                'pcb_id' => $pcb->id,
                'process' => $process,
                'result' => 'ok',
                'box_type' => 'OK',
                'notes' => 'Process completed successfully'
            ]);

            DB::commit();

            // Pesan sukses yang lebih informatif
            $stepNames = [
                'fct' => 'FCT',
                'led_test' => 'LED Test',
                'visual_inspection' => 'Visual Inspection'
            ];
            
            $stepName = $stepNames[$process] ?? strtoupper($process);
            $isComplete = $pcb->status === 'completed';
            
            $message = '✅ PCB ' . $serialNumber . ' passed ' . $stepName . ' successfully!';
            if ($isComplete) {
                $message = '🎉 PCB ' . $serialNumber . ' COMPLETED all 3 steps!';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'pcb' => $pcb,
                'process_completed' => $isComplete
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            
            // Tangani error duplicate entry
            if ($e->getCode() == 23000 && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Serial number "' . $serialNumber . '" already exists in system. Please use a unique serial number.',
                    'error_type' => 'duplicate'
                ], 409);
            }
            
            Log::error('Database error: ' . $e->getMessage(), [
                'serial_number' => $serialNumber,
                'process' => $process,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => '⚠️ System error occurred. Please try again or contact IT support.'
            ], 500);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Process scan error: ' . $e->getMessage(), [
                'serial_number' => $serialNumber,
                'process' => $process,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => '⚠️ System error occurred. Please try again or contact IT support.'
            ], 500);
        }
    }

    public function checkSystemLock()
    {
        try {
            $lockedBoxes = NGBox::with('pcb')
                                ->where('is_locked', true)
                                ->latest()
                                ->get();
            
            $isLocked = $lockedBoxes->isNotEmpty();
            
            return response()->json([
                'is_locked' => $isLocked,
                'locked_boxes' => $lockedBoxes,
                'message' => $isLocked ? 'System is locked' : 'System is online',
                'count' => $lockedBoxes->count(),
                'timestamp' => now()->toDateTimeString(),
            ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        } catch (\Exception $e) {
            return response()->json([
                'is_locked' => false,
                'message' => 'Error checking system lock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getRecentScans($process)
    {
        try {
            $scans = ScanLog::where('process', $process)
                            ->whereDate('created_at', today())
                            ->latest()
                            ->take(5)
                            ->get(['serial_number', 'pcb_id', 'result', 'created_at']);
            
            // Log untuk debugging
            \Log::info('Recent scans API called', [
                'process' => $process,
                'count' => $scans->count(),
                'data' => $scans->toArray()
            ]);
            
            return response()->json($scans);
        } catch (\Exception $e) {
            \Log::error('Error in getRecentScans', [
                'process' => $process,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'error' => 'Failed to load recent scans',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTodayStats($process)
    {
        try {
            $today = today();
            
            $ok = ScanLog::where('process', $process)
                         ->whereDate('created_at', $today)
                         ->where('result', 'ok')
                         ->count();
            
            $ng = ScanLog::where('process', $process)
                         ->whereDate('created_at', $today)
                         ->where('result', 'ng')
                         ->count();
            
            return response()->json([
                'ok' => $ok,
                'ng' => $ng,
                'total' => $ok + $ng
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load stats',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getVisualStats()
    {
        try {
            $today = today();
            
            $completed = PCB::whereDate('updated_at', $today)
                            ->where('status', 'completed')
                            ->count();
            
            $total = ScanLog::where('process', 'visual_inspection')
                            ->whereDate('created_at', $today)
                            ->count();
            
            $passRate = $total > 0 ? round(($completed / $total) * 100) : 0;
            
            $inQueue = PCB::where('status', 'in_progress')
                          ->where('current_process', 'visual_inspection')
                          ->count();
            
            return response()->json([
                'completed_today' => $completed,
                'pass_rate' => $passRate,
                'in_queue' => $inQueue
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load visual stats',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDashboardStats()
    {
        try {
            $today = today();
            
            $totalScans = ScanLog::whereDate('created_at', $today)->count();
            $okScans = ScanLog::whereDate('created_at', $today)->where('result', 'ok')->count();
            $ngScans = ScanLog::whereDate('created_at', $today)->where('result', 'ng')->count();
            $completedPCBs = PCB::whereDate('updated_at', $today)->where('status', 'completed')->count();
            
            return response()->json([
                'total_scans' => $totalScans,
                'ok_scans' => $okScans,
                'ng_scans' => $ngScans,
                'completed_pcbs' => $completedPCBs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load dashboard stats',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}