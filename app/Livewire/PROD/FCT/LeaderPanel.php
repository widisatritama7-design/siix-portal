<?php

namespace App\Livewire\PROD\FCT;

use App\Models\PROD\FCT\NGBox;
use App\Models\PROD\FCT\PCB;
use App\Models\PROD\FCT\ScanLog;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class LeaderPanel extends Component
{
    use WithPagination;

    // Properties
    public $activeTab = 'ng';
    public $search = '';
    public $unlockCode = '';
    public $showUnlockModal = false;
    public $selectedBox = null;
    public $unlockMessage = '';
    public $unlockMessageType = '';

    // Modal View Code
    public $showCodeModal = false;
    public $passwordInput = '';
    public $selectedBoxForCode = null;
    public $passwordError = '';
    public $showCodeResult = false;
    public $displayedCode = '';

    // Listeners
    protected $listeners = [
        'refreshLeader' => '$refresh',
        'unlocked' => 'handleUnlocked'
    ];

    /**
     * Mount method - Reset search dan session
     */
    public function mount()
    {
        // Hapus semua session search
        session()->forget(['search', 'fct_search', 'pcb_search']);
        
        // Set default tab
        $this->activeTab = session('active_tab', 'ng');
        
        // Pastikan search kosong
        $this->search = '';
    }

    /**
     * Switch tab - Reset search saat ganti tab
     */
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        session(['active_tab' => $tab]);
        
        // Reset search saat ganti tab
        $this->search = '';
        session()->forget('search');
        
        $this->resetPage();
    }

    /**
     * Updated search - Reset page saat search berubah
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // ========== UNLOCK MODAL METHODS ==========

    public function openUnlockModal($id)
    {
        $this->selectedBox = NGBox::with('pcb')->find($id);
        
        if (!$this->selectedBox || !$this->selectedBox->is_locked) {
            $this->unlockMessage = 'This box is already unlocked.';
            $this->unlockMessageType = 'warning';
            return;
        }
        
        $this->unlockCode = '';
        $this->unlockMessage = '';
        $this->unlockMessageType = '';
        $this->showUnlockModal = true;
        
        $this->dispatch('open-unlock-modal');
    }

    public function closeUnlockModal()
    {
        $this->showUnlockModal = false;
        $this->selectedBox = null;
        $this->unlockCode = '';
        $this->dispatch('close-unlock-modal');
    }

    public function unlockBox()
    {
        if (!$this->selectedBox) {
            return;
        }

        $this->validate([
            'unlockCode' => 'required|string|size:6'
        ]);

        try {
            if ($this->selectedBox->unlock_code !== $this->unlockCode) {
                $this->unlockMessage = '❌ Invalid unlock code. Please try again.';
                $this->unlockMessageType = 'error';
                return;
            }

            $this->selectedBox->is_locked = false;
            $this->selectedBox->unlocked_by = auth()->user()->name ?? 'Leader';
            $this->selectedBox->unlocked_at = now();
            $this->selectedBox->save();

            $this->unlockMessage = '✅ Box ' . $this->selectedBox->serial_number . ' unlocked successfully.';
            $this->unlockMessageType = 'success';
            
            $this->dispatch('unlocked');
            $this->dispatch('close-unlock-modal');
            $this->dispatch('close-modal-delay');

        } catch (\Exception $e) {
            $this->unlockMessage = '❌ Error unlocking box: ' . $e->getMessage();
            $this->unlockMessageType = 'error';
        }
    }

    public function handleUnlocked()
    {
        $this->dispatch('refreshLeader');
    }

    // ========== CODE VIEW MODAL METHODS ==========

    public function showUnlockCode($id)
    {
        $this->selectedBoxForCode = NGBox::find($id);
        $this->passwordInput = '';
        $this->passwordError = '';
        $this->showCodeResult = false;
        $this->displayedCode = '';
        $this->showCodeModal = true;
        $this->dispatch('open-code-modal');
    }

    public function closeCodeModal()
    {
        $this->showCodeModal = false;
        $this->selectedBoxForCode = null;
        $this->passwordInput = '';
        $this->passwordError = '';
        $this->showCodeResult = false;
        $this->displayedCode = '';
        $this->dispatch('close-code-modal');
    }

    public function verifyPassword()
    {
        $this->validate([
            'passwordInput' => 'required|string'
        ]);

        $user = auth()->user();
        
        if ($user && Hash::check($this->passwordInput, $user->password)) {
            $this->passwordError = '';
            $this->showCodeResult = true;
            $this->displayedCode = $this->selectedBoxForCode->unlock_code ?? '';
        } else {
            $this->passwordError = 'Invalid password. Please try again.';
            $this->showCodeResult = false;
            $this->displayedCode = '';
        }
    }

    // ========== QUERY PROPERTIES ==========

    public function getNgBoxesProperty()
    {
        return NGBox::with('pcb')
            ->when($this->search, function ($query) {
                $query->where('serial_number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getAllPcbsProperty()
    {
        return PCB::whereNotIn('status', ['blocked', 'ng'])
            ->when($this->search, function ($query) {
                $query->where('serial_number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getInProgressPcbsProperty()
    {
        return PCB::where('status', 'in_progress')
            ->whereDoesntHave('ngBoxes')
            ->when($this->search, function ($query) {
                $query->where('serial_number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
    }

    public function getCompletedPcbsProperty()
    {
        return PCB::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->when($this->search, function ($query) {
                $query->where('serial_number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
    }

    public function getStatsProperty()
    {
        $today = today()->toDateString();
        
        return [
            'totalToday' => ScanLog::whereDate('created_at', $today)
                ->distinct('serial_number')
                ->count('serial_number'),
            'completedToday' => ScanLog::whereDate('created_at', $today)
                ->where('result', 'ok')
                ->select('serial_number')
                ->groupBy('serial_number')
                ->havingRaw('COUNT(DISTINCT process) = 3')
                ->get()
                ->count(),
            'inProgressToday' => ScanLog::whereDate('created_at', $today)
                ->where('result', 'ok')
                ->select('serial_number')
                ->groupBy('serial_number')
                ->havingRaw('COUNT(DISTINCT process) < 3')
                ->get()
                ->count(),
            'ngToday' => ScanLog::whereDate('created_at', $today)
                ->where('result', 'ng')
                ->distinct('serial_number')
                ->count('serial_number'),
            'fctCompleted' => ScanLog::whereDate('created_at', $today)
                ->where('process', 'fct')
                ->where('result', 'ok')
                ->distinct('serial_number')
                ->count('serial_number'),
            'ledCompleted' => ScanLog::whereDate('created_at', $today)
                ->where('process', 'led_test')
                ->where('result', 'ok')
                ->distinct('serial_number')
                ->count('serial_number'),
            'visualCompleted' => ScanLog::whereDate('created_at', $today)
                ->where('process', 'visual_inspection')
                ->where('result', 'ok')
                ->distinct('serial_number')
                ->count('serial_number'),
        ];
    }

    /**
     * Render view - Tanpa pengecekan NIK otomatis
     */
    public function render()
    {
        return view('livewire.prod.fct.leader-panel', [
            'ngBoxes' => $this->ngBoxes,
            'allPcbs' => $this->allPcbs,
            'inProgressPcbs' => $this->inProgressPcbs,
            'completedPcbs' => $this->completedPcbs,
            'stats' => $this->stats,
        ]);
    }
}