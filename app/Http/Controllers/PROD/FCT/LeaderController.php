<?php

namespace App\Http\Controllers\PROD\FCT;

use App\Http\Controllers\Controller;
use App\Models\PROD\FCT\Leader;
use App\Models\PROD\FCT\NGBox;
use App\Models\PROD\FCT\PCB;
use App\Models\PROD\FCT\ScanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaderController extends Controller
{
    public function index()
    {
        // Get locked boxes dengan pagination
        $ngBoxes = NGBox::with('pcb')
            ->where('is_locked', true)
            ->latest()
            ->paginate(10);
        
        // All PCBs dengan pagination
        $allPcbs = PCB::orderBy('created_at', 'desc')
            ->paginate(10);
        
        // In Progress PCBs dengan pagination
        $inProgressPcbs = PCB::where('status', 'in_progress')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        // Completed PCBs dengan pagination
        $completedPcbs = PCB::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        // Today's date
        $today = now()->toDateString();
        
        // Total unique PCBs today
        $totalToday = ScanLog::whereDate('created_at', $today)
            ->distinct('serial_number')
            ->count('serial_number');
        
        // Completed PCBs (all 3 steps passed)
        $completedToday = ScanLog::whereDate('created_at', $today)
            ->where('result', 'ok')
            ->select('serial_number')
            ->groupBy('serial_number')
            ->havingRaw('COUNT(DISTINCT process) = 3')
            ->get()
            ->count();
        
        // PCBs in progress
        $inProgressToday = ScanLog::whereDate('created_at', $today)
            ->where('result', 'ok')
            ->select('serial_number')
            ->groupBy('serial_number')
            ->havingRaw('COUNT(DISTINCT process) < 3')
            ->get()
            ->count();
        
        // NG PCBs today
        $ngToday = ScanLog::whereDate('created_at', $today)
            ->where('result', 'ng')
            ->distinct('serial_number')
            ->count('serial_number');
        
        // Step completion counts
        $fctCompleted = ScanLog::whereDate('created_at', $today)
            ->where('process', 'fct')
            ->where('result', 'ok')
            ->distinct('serial_number')
            ->count('serial_number');
        
        $ledCompleted = ScanLog::whereDate('created_at', $today)
            ->where('process', 'led_test')
            ->where('result', 'ok')
            ->distinct('serial_number')
            ->count('serial_number');
        
        $visualCompleted = ScanLog::whereDate('created_at', $today)
            ->where('process', 'visual_inspection')
            ->where('result', 'ok')
            ->distinct('serial_number')
            ->count('serial_number');
        
        return view('livewire.prod.fct.leader.index', compact(
            'ngBoxes',
            'allPcbs',
            'inProgressPcbs',
            'completedPcbs',
            'totalToday',
            'completedToday',
            'inProgressToday',
            'ngToday',
            'fctCompleted',
            'ledCompleted',
            'visualCompleted'
        ));
    }

    public function showUnlockForm($id)
    {
        $ngBox = NGBox::with('pcb')->findOrFail($id);
        
        if (!$ngBox->is_locked) {
            return redirect()->route('pcb-scan.leader.index')
                ->with('info', 'This box is already unlocked.');
        }
        
        return view('livewire.prod.fct.leader.unlock', compact('ngBox'));
    }

    public function unlock(Request $request, $id)
    {
        $request->validate([
            'unlock_code' => 'required|string|size:6'
        ]);

        try {
            $ngBox = NGBox::findOrFail($id);
            
            // Check if box is already unlocked
            if (!$ngBox->is_locked) {
                return redirect()->route('pcb-scan.leader.index')
                    ->with('info', 'This box is already unlocked.');
            }
            
            // Verify unlock code
            if ($ngBox->unlock_code !== $request->unlock_code) {
                return redirect()->route('pcb-scan.leader.unlock.form', $id)
                    ->with('error', 'Invalid unlock code. Please try again.');
            }
            
            // Unlock the box (is_locked = false)
            $ngBox->is_locked = false;
            $ngBox->unlocked_by = auth()->user()->name ?? 'Leader';
            $ngBox->unlocked_at = now();
            $ngBox->save();

            // Update PCB status - TETAP BLOCKED, tidak boleh in_progress
            if ($ngBox->pcb) {
                $pcb = $ngBox->pcb;
                
                // Status tetap BLOCKED
                $pcb->status = 'blocked';
                // current_process tetap di proses dimana dia di-block
                // $pcb->current_process = $ngBox->blocked_at_process; // sudah ada
                
                $pcb->save();
            }

            return redirect()->route('pcb-scan.leader.index')
                ->with('success', 'Box ' . $ngBox->serial_number . ' unlocked successfully. PCB remains BLOCKED.');

        } catch (\Exception $e) {
            Log::error('Unlock error: ' . $e->getMessage(), [
                'ng_box_id' => $id
            ]);
            
            return redirect()->route('pcb-scan.leader.unlock.form', $id)
                ->with('error', 'Error unlocking box: ' . $e->getMessage());
        }
    }

    public function settings()
    {
        $leaders = Leader::all();
        return view('livewire.prod.fct.leader.settings', compact('leaders'));
    }

    public function generateCode(Request $request)
    {
        try {
            $code = Leader::generateUniqueCode();
            
            return response()->json([
                'success' => true,
                'code' => $code
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating code: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeLeader(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|unique:leaders,employee_id',
            'name' => 'required|string|max:255',
        ]);

        try {
            // Generate random unlock code
            $unlockCode = Leader::generateUniqueCode();

            Leader::create([
                'employee_id' => $request->employee_id,
                'name' => $request->name,
                'unlock_code' => $unlockCode,
                'is_active' => true
            ]);

            return redirect()->route('pcb-scan.leader.settings')
                ->with('success', 'Leader added successfully. Unlock code: ' . $unlockCode);

        } catch (\Exception $e) {
            return redirect()->route('pcb-scan.leader.settings')
                ->with('error', 'Error adding leader: ' . $e->getMessage());
        }
    }

    public function updateLeader(Request $request, $id)
    {
        $leader = Leader::findOrFail($id);
        
        $request->validate([
            'employee_id' => 'required|unique:leaders,employee_id,' . $id,
            'name' => 'required|string|max:255',
        ]);

        try {
            $data = [
                'employee_id' => $request->employee_id,
                'name' => $request->name,
            ];

            // Regenerate code if requested
            if ($request->has('regenerate_code') && $request->regenerate_code) {
                $data['unlock_code'] = Leader::generateUniqueCode();
            }

            $leader->update($data);

            $message = 'Leader updated successfully.';
            if (isset($data['unlock_code'])) {
                $message .= ' New unlock code: ' . $data['unlock_code'];
            }

            return redirect()->route('pcb-scan.leader.settings')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('pcb-scan.leader.settings')
                ->with('error', 'Error updating leader: ' . $e->getMessage());
        }
    }

    public function regenerateCode($id)
    {
        try {
            $leader = Leader::findOrFail($id);
            
            $newCode = Leader::generateUniqueCode();
            $leader->unlock_code = $newCode;
            $leader->save();
            
            return response()->json([
                'success' => true,
                'code' => $newCode,
                'message' => 'Unlock code regenerated successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error regenerating code: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleLeaderStatus($id)
    {
        try {
            $leader = Leader::findOrFail($id);
            $leader->is_active = !$leader->is_active;
            $leader->save();

            $status = $leader->is_active ? 'activated' : 'deactivated';
            
            return redirect()->route('pcb-scan.leader.settings')
                ->with('success', "Leader {$status} successfully.");

        } catch (\Exception $e) {
            return redirect()->route('pcb-scan.leader.settings')
                ->with('error', 'Error toggling leader status: ' . $e->getMessage());
        }
    }

    public function deleteLeader($id)
    {
        try {
            $leader = Leader::findOrFail($id);
            
            // Check if leader has any unlock history
            $hasUnlocks = NGBox::where('unlocked_by', 'Leader_' . $leader->id)->exists();
            
            if ($hasUnlocks) {
                // Deactivate instead of delete
                $leader->is_active = false;
                $leader->save();
                
                return redirect()->route('pcb-scan.leader.settings')
                    ->with('warning', 'Leader has unlock history. Account has been deactivated instead of deleted.');
            }
            
            $leader->delete();
            
            return redirect()->route('pcb-scan.leader.settings')
                ->with('success', 'Leader deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('pcb-scan.leader.settings')
                ->with('error', 'Error deleting leader: ' . $e->getMessage());
        }
    }
}