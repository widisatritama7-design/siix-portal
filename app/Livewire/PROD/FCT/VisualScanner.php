<?php

namespace App\Livewire\PROD\FCT;

use App\Models\PROD\FCT\NGBox;
use App\Models\PROD\FCT\PCB;
use App\Models\PROD\FCT\ScanLog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VisualScanner extends Component
{
    public $serialNumber = '';
    public $isProcessing = false;
    public $result = null;
    public $resultType = null;
    public $resultMessage = '';
    public $isSystemLocked = false;
    public $lockMessage = '';
    public $recentScans = [];
    public $refreshTime = '';
    public $showCompletion = false;

    protected $listeners = ['refreshScanner' => '$refresh', 'refreshRecentScans' => 'loadRecentScans'];

    public function mount()
    {
        $this->checkSystemLock();
        $this->loadRecentScans();
    }

    public function checkSystemLock()
    {
        $lockedBox = NGBox::where('is_locked', true)->first();
        $this->isSystemLocked = $lockedBox ? true : false;
        $this->lockMessage = $lockedBox ? 'Locked by: ' . $lockedBox->serial_number : '';
    }

    public function loadRecentScans()
    {
        $this->recentScans = ScanLog::where('process', 'visual_inspection')
            ->whereDate('created_at', today())
            ->latest()
            ->take(5)
            ->get(['serial_number', 'created_at'])
            ->toArray();
        
        $this->refreshTime = now()->format('H:i:s');
    }

    public function processScan()
    {
        if ($this->isProcessing) {
            return;
        }

        $this->validate([
            'serialNumber' => 'required|string|max:255'
        ]);

        $serialNumber = trim($this->serialNumber);

        if (empty($serialNumber)) {
            $this->showResult('error', 'Please scan a barcode');
            return;
        }

        $this->isProcessing = true;

        DB::beginTransaction();

        try {
            $activeNG = NGBox::where('is_locked', true)->first();
            if ($activeNG) {
                $this->showResult('error', 'SYSTEM LOCKED: There is an active NG Box. Please ask leader to unlock.');
                $this->isProcessing = false;
                $this->dispatch('redirect-to-leader');
                return;
            }

            // CEK DUPLIKAT: Apakah serial number sudah pernah di-block sebelumnya?
            $hasEverBlocked = NGBox::where('serial_number', $serialNumber)->exists();
            
            if ($hasEverBlocked) {
                $this->showResult('warning', 'Serial number "' . $serialNumber . '" has been blocked before. Please use a new PCB.');
                $this->serialNumber = '';
                $this->isProcessing = false;
                DB::rollBack();
                return;
            }

            $existingCompletedPCB = PCB::where('serial_number', $serialNumber)
                                      ->where('status', 'completed')
                                      ->first();
            
            if ($existingCompletedPCB) {
                $pcb = PCB::create([
                    'serial_number' => $serialNumber,
                    'status' => 'pending',
                    'current_process' => null,
                    'fct_completed' => false,
                    'led_test_completed' => false,
                    'visual_inspection_completed' => false
                ]);
            } else {
                $pcb = PCB::where('serial_number', $serialNumber)
                          ->where('status', '!=', 'completed')
                          ->first();
                
                if (!$pcb) {
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

            $canProceed = true;
            $errorMessage = '';

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

            if (!$canProceed) {
                do {
                    $unlockCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                } while (NGBox::where('unlock_code', $unlockCode)->exists());
                
                if (!$pcb->id) {
                    $pcb->save();
                }
                
                NGBox::create([
                    'serial_number' => $serialNumber,
                    'pcb_id' => $pcb->id,
                    'blocked_at_process' => 'visual_inspection',
                    'is_locked' => true,
                    'unlock_code' => $unlockCode,
                    'locked_at' => now()
                ]);

                $pcb->status = 'blocked';
                $pcb->save();

                ScanLog::create([
                    'serial_number' => $serialNumber,
                    'pcb_id' => $pcb->id,
                    'process' => 'visual_inspection',
                    'result' => 'ng',
                    'box_type' => 'NG',
                    'notes' => $errorMessage
                ]);

                DB::commit();

                $this->showResult('error', '' . $errorMessage . '. PCB sent to NG Box.');
                $this->dispatch('ng-box-created', unlock_code: $unlockCode);
                $this->serialNumber = '';
                $this->isProcessing = false;
                $this->checkSystemLock();
                $this->loadRecentScans();
                return;
            }

            $pcb->visual_inspection_completed = true;
            $pcb->visual_inspection_completed_at = now();
            $pcb->current_process = 'visual_inspection';
            $pcb->status = 'completed';
            $pcb->current_process = 'completed';
            $pcb->save();

            ScanLog::create([
                'serial_number' => $serialNumber,
                'pcb_id' => $pcb->id,
                'process' => 'visual_inspection',
                'result' => 'ok',
                'box_type' => 'OK',
                'notes' => 'Visual Inspection completed successfully - PCB COMPLETE!'
            ]);

            DB::commit();

            $this->showCompletion = true;
            $this->showResult('success', 'PCB ' . $serialNumber . ' COMPLETED all 3 steps!');
            $this->dispatch('complete-sound');
            $this->dispatch('beep-sound');
            $this->serialNumber = '';
            $this->isProcessing = false;
            $this->loadRecentScans();

            $this->dispatch('hide-completion');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            
            if ($e->getCode() == 23000 && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $this->showResult('warning', 'Serial number "' . $serialNumber . '" already exists. Please use a unique serial number.');
            } else {
                $this->showResult('error', 'Database error occurred. Please try again.');
            }
            
            $this->serialNumber = '';
            $this->isProcessing = false;
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showResult('error', 'System error occurred. Please try again or contact IT support.');
            $this->serialNumber = '';
            $this->isProcessing = false;
        }
    }

    public function showResult($type, $message)
    {
        $this->resultType = $type;
        $this->resultMessage = $message;
        $this->result = true;
        
        if ($type === 'error' || $type === 'warning') {
            $this->dispatch('error-sound');
        }
    }

    public function clearResult()
    {
        $this->result = null;
        $this->resultType = null;
        $this->resultMessage = '';
    }

    public function hideCompletion()
    {
        $this->showCompletion = false;
    }

    public function render()
    {
        return view('livewire.prod.fct.visual-scanner');
    }
}