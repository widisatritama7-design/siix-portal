<?php

namespace App\Livewire\MTC\Master;

use App\Models\MTC\Master\MasterLine;
use App\Models\MTC\Master\MasterLocation;
use App\Models\MTC\Daily\DailyPanasonicStandardCheck;
use App\Models\MTC\Daily\DailyPanasonicStandardCheckHistory;
use App\Models\MTC\Daily\DailyFUjiStandardCheckHistory;
use App\Models\HR\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterLineManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Properties untuk form
    public $line_id;
    public $location_id;
    public $line_number;
    public $status;
    public $nik;
    public $trouble_desc;
    public $machine_type;
    
    // Properties untuk search, filter dan delete
    public $search = '';
    public $selectedLocation = '';
    public $selectedMachineType = '';
    public $selectedStatus = '';
    public $lineToDelete;

    // Tambahkan property ini setelah property yang sudah ada
    public $standardFields = [];
    public $selectedLineForStandard;
    public $standardConfig = [];

    // Properties
    public $panasonicStandardFields = [];
    public $selectedLineForPanasonicStandard;
    public $panasonicStandardConfig = [];

    // Di dalam class MasterLineManagement
    public $showHistoryModal = false;
    public $historyData = [];
    public $historyLineNumber = '';
    public $historyType = 'fuji';
    
    // Modal title
    public $modalTitle = 'Add New Line';

    protected $rules = [
        'location_id' => 'required|exists:tb_mtc_master_locations,id',
        'line_number' => 'required|string|max:255', // Hapus unique:tb_mtc_master_lines,line_number
        'status' => 'required|in:Running,Maintenance,No Schedule,Trouble',
        'nik' => 'nullable|exists:hr_employees,ID',
        'trouble_desc' => 'nullable|string',
        'machine_type' => 'required|in:fuji,panasonic,both',
    ];

    protected $messages = [
        'location_id.required' => 'Location is required.',
        'location_id.exists' => 'Selected location is invalid.',
        'line_number.required' => 'Line number is required.',
        'status.required' => 'Status is required.',
        'machine_type.required' => 'Machine type is required.',
        'nik.exists' => 'Selected employee is invalid.',
    ];

    private function createFujiHistory($standard, $oldData, $newData, $action)
    {
        $changes = [];
        
        // Detect changes
        foreach ($newData as $key => $value) {
            if (str_ends_with($key, '_required')) {
                $oldValue = $oldData[$key] ?? false;
                $newValue = $value;
                
                if ($oldValue != $newValue) {
                    $fieldName = str_replace('_required', '', $key);
                    $changes[$fieldName] = [
                        'old' => $oldValue ? 'Required' : 'Optional',
                        'new' => $newValue ? 'Required' : 'Optional',
                    ];
                }
            }
        }

        // Jika action create, simpan semua field
        if ($action === 'create' && empty($changes)) {
            foreach ($newData as $key => $value) {
                if (str_ends_with($key, '_required')) {
                    $fieldName = str_replace('_required', '', $key);
                    $changes[$fieldName] = [
                        'old' => 'Not Set',
                        'new' => $value ? 'Required' : 'Optional',
                    ];
                }
            }
        }

        if (!empty($changes)) {
            DailyFujiStandardCheckHistory::create([
                'standard_check_id' => $standard->id,
                'master_line_id' => $standard->master_line_id,
                'user_id' => auth()->id(),
                'action' => $action,
                'changes' => $changes,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    private function createPanasonicHistory($standard, $oldData, $newData, $action)
    {
        $changes = [];
        
        foreach ($newData as $key => $value) {
            if (str_ends_with($key, '_required')) {
                $oldValue = $oldData[$key] ?? false;
                $newValue = $value;
                
                if ($oldValue != $newValue) {
                    $fieldName = str_replace('_required', '', $key);
                    $changes[$fieldName] = [
                        'old' => $oldValue ? 'Required' : 'Optional',
                        'new' => $newValue ? 'Required' : 'Optional',
                    ];
                }
            }
        }

        if ($action === 'create' && empty($changes)) {
            foreach ($newData as $key => $value) {
                if (str_ends_with($key, '_required')) {
                    $fieldName = str_replace('_required', '', $key);
                    $changes[$fieldName] = [
                        'old' => 'Not Set',
                        'new' => $value ? 'Required' : 'Optional',
                    ];
                }
            }
        }

        if (!empty($changes)) {
            DailyPanasonicStandardCheckHistory::create([
                'standard_check_id' => $standard->id,
                'master_line_id' => $standard->master_line_id,
                'user_id' => auth()->id(),
                'action' => $action,
                'changes' => $changes,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
    /**
     * Open standard configuration modal for a line
     */
    public function configureStandard($id)
    {
        // Check permission
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to configure standard!', type: 'error');
            return;
        }

        try {
            $line = MasterLine::with('dailyFujiStandardCheck')->findOrFail($id);
            $this->selectedLineForStandard = $line;
            
            // Load existing configuration or create default
            if ($line->dailyFujiStandardCheck) {
                $standard = $line->dailyFujiStandardCheck;
                // Load semua field ke standardConfig
                $fillable = (new \App\Models\MTC\Daily\DailyFujiStandardCheck)->getFillable();
                foreach ($fillable as $field) {
                    if (str_ends_with($field, '_required')) {
                        $this->standardConfig[$field] = (bool) $standard->{$field};
                    }
                }
            } else {
                // Default: semua true
                $fillable = (new \App\Models\MTC\Daily\DailyFujiStandardCheck)->getFillable();
                foreach ($fillable as $field) {
                    if (str_ends_with($field, '_required')) {
                        $this->standardConfig[$field] = true;
                    }
                }
            }
            
            $this->dispatch('open-standard-modal');
            
        } catch (\Exception $e) {
            Log::error('Error loading standard config: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to load standard configuration!', type: 'error');
        }
    }

    /**
     * Save standard configuration
     */
    public function saveStandardConfig()
    {
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to configure standard!', type: 'error');
            return;
        }

        try {
            $line = $this->selectedLineForStandard;
            $standard = $line->dailyFujiStandardCheck;
            $oldData = [];
            $action = 'create';
            
            if ($standard) {
                // Simpan data lama sebelum update
                $oldData = $standard->toArray();
                $standard->update($this->standardConfig);
                $newData = $standard->fresh()->toArray();
                $action = 'update';
            } else {
                $newStandard = new DailyFujiStandardCheck();
                $newStandard->master_line_id = $line->id;
                foreach ($this->standardConfig as $field => $value) {
                    $newStandard->{$field} = $value;
                }
                $newStandard->save();
                $standard = $newStandard;
                $newData = $standard->toArray();
            }

            // Buat history
            $this->createFujiHistory($standard, $oldData, $newData, $action);

            $this->dispatch('close-standard-modal');
            $this->dispatch('notify', message: 'Standard configuration saved successfully!', type: 'success');
            
            $this->standardConfig = [];
            $this->selectedLineForStandard = null;
            
        } catch (\Exception $e) {
            Log::error('Error saving standard config: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to save standard configuration!', type: 'error');
        }
    }

    /**
     * Reset standard config
     */
    public function resetStandardConfig()
    {
        $this->standardConfig = [];
        $this->selectedLineForStandard = null;
    }

    /**
     * Set all fields to required or not required
     */
    public function setAllRequired($value)
    {
        foreach ($this->standardConfig as $field => $oldValue) {
            $this->standardConfig[$field] = $value;
        }
    }

    // Method configurePanasonicStandard
    public function configurePanasonicStandard($id)
    {
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to configure standard!', type: 'error');
            return;
        }

        try {
            $line = MasterLine::with('dailyPanasonicStandardCheck')->findOrFail($id);
            $this->selectedLineForPanasonicStandard = $line;
            
            if ($line->dailyPanasonicStandardCheck) {
                $standard = $line->dailyPanasonicStandardCheck;
                $fillable = (new \App\Models\MTC\Daily\DailyPanasonicStandardCheck)->getFillable();
                foreach ($fillable as $field) {
                    if (str_ends_with($field, '_required')) {
                        $this->panasonicStandardConfig[$field] = (bool) $standard->{$field};
                    }
                }
            } else {
                $fillable = (new \App\Models\MTC\Daily\DailyPanasonicStandardCheck)->getFillable();
                foreach ($fillable as $field) {
                    if (str_ends_with($field, '_required')) {
                        $this->panasonicStandardConfig[$field] = true;
                    }
                }
            }
            
            $this->dispatch('open-panasonic-standard-modal');
            
        } catch (\Exception $e) {
            Log::error('Error loading Panasonic standard config: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to load Panasonic standard configuration!', type: 'error');
        }
    }

    // Method savePanasonicStandardConfig
    public function savePanasonicStandardConfig()
    {
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to configure standard!', type: 'error');
            return;
        }

        try {
            $line = $this->selectedLineForPanasonicStandard;
            $standard = $line->dailyPanasonicStandardCheck;
            $oldData = [];
            $action = 'create';
            
            if ($standard) {
                $oldData = $standard->toArray();
                $standard->update($this->panasonicStandardConfig);
                $newData = $standard->fresh()->toArray();
                $action = 'update';
            } else {
                $newStandard = new DailyPanasonicStandardCheck();
                $newStandard->master_line_id = $line->id;
                foreach ($this->panasonicStandardConfig as $field => $value) {
                    $newStandard->{$field} = $value;
                }
                $newStandard->save();
                $standard = $newStandard;
                $newData = $standard->toArray();
            }

            $this->createPanasonicHistory($standard, $oldData, $newData, $action);

            $this->dispatch('close-panasonic-standard-modal');
            $this->dispatch('notify', message: 'Panasonic standard configuration saved successfully!', type: 'success');
            
            $this->panasonicStandardConfig = [];
            $this->selectedLineForPanasonicStandard = null;
            
        } catch (\Exception $e) {
            Log::error('Error saving Panasonic standard config: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to save Panasonic standard configuration!', type: 'error');
        }
    }
    
    public function viewStandardHistory($lineId, $type = 'fuji')
    {
        $this->historyType = $type;
        $line = MasterLine::findOrFail($lineId);
        $this->historyLineNumber = $line->line_number;

        if ($type === 'fuji' || $type === 'both') {
            $standard = $line->dailyFujiStandardCheck;
            if ($standard) {
                $this->historyData = $standard->histories()->with('user')->get()->map(function ($history) {
                    // Group changes by step
                    $changesByStep = [];
                    $changes = $history->changes;
                    
                    if (!empty($changes) && is_array($changes)) {
                        foreach ($changes as $field => $change) {
                            $step = DailyFujiStandardCheck::getStepForField($field);
                            if ($step) {
                                $stepName = DailyFujiStandardCheck::getStepName($step);
                                if (!isset($changesByStep[$step])) {
                                    $changesByStep[$step] = [
                                        'step_number' => $step,
                                        'step_name' => $stepName,
                                        'fields' => []
                                    ];
                                }
                                $changesByStep[$step]['fields'][$field] = $change;
                            } else {
                                // If step not found, put in "Other"
                                if (!isset($changesByStep['other'])) {
                                    $changesByStep['other'] = [
                                        'step_number' => 'other',
                                        'step_name' => 'OTHER',
                                        'fields' => []
                                    ];
                                }
                                $changesByStep['other']['fields'][$field] = $change;
                            }
                        }
                    }
                    
                    return [
                        'id' => $history->id,
                        'user_name' => $history->user->name ?? 'System',
                        'action' => $history->action,
                        'changes' => $changes,
                        'changes_by_step' => $changesByStep,
                        'created_at' => $history->created_at,
                        'ip_address' => $history->ip_address,
                    ];
                })->toArray();
                
                if (!empty($this->historyData)) {
                    $this->historyType = 'fuji';
                    $this->dispatch('open-history-modal');
                    return;
                }
            }
        }

        if ($type === 'panasonic' || $type === 'both') {
            $standard = $line->dailyPanasonicStandardCheck;
            if ($standard) {
                $this->historyData = $standard->histories()->with('user')->get()->map(function ($history) {
                    // Group changes by step
                    $changesByStep = [];
                    $changes = $history->changes;
                    
                    if (!empty($changes) && is_array($changes)) {
                        foreach ($changes as $field => $change) {
                            $step = DailyPanasonicStandardCheck::getStepForField($field);
                            if ($step) {
                                $stepName = DailyPanasonicStandardCheck::getStepName($step);
                                if (!isset($changesByStep[$step])) {
                                    $changesByStep[$step] = [
                                        'step_number' => $step,
                                        'step_name' => $stepName,
                                        'fields' => []
                                    ];
                                }
                                $changesByStep[$step]['fields'][$field] = $change;
                            } else {
                                if (!isset($changesByStep['other'])) {
                                    $changesByStep['other'] = [
                                        'step_number' => 'other',
                                        'step_name' => 'OTHER',
                                        'fields' => []
                                    ];
                                }
                                $changesByStep['other']['fields'][$field] = $change;
                            }
                        }
                    }
                    
                    return [
                        'id' => $history->id,
                        'user_name' => $history->user->name ?? 'System',
                        'action' => $history->action,
                        'changes' => $changes,
                        'changes_by_step' => $changesByStep,
                        'created_at' => $history->created_at,
                        'ip_address' => $history->ip_address,
                    ];
                })->toArray();
                
                if (!empty($this->historyData)) {
                    $this->historyType = 'panasonic';
                    $this->dispatch('open-history-modal');
                    return;
                }
            }
        }

        $this->historyData = [];
        $this->dispatch('open-history-modal');
    }
    // Method setAllPanasonicRequired
    public function setAllPanasonicRequired($value)
    {
        foreach ($this->panasonicStandardConfig as $field => $oldValue) {
            $this->panasonicStandardConfig[$field] = $value;
        }
    }

    /**
     * Change machine type for a line
     */
    public function changeMachineType($id)
    {
        // Check permission
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to change machine type!', type: 'error');
            return;
        }

        try {
            $line = MasterLine::findOrFail($id);
            $this->line_id = $line->id;
            $this->machine_type = $line->machine_type;
            $this->modalTitle = 'Change Machine Type';
            $this->resetValidation();
            
            $this->dispatch('open-change-machine-modal');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Line not found!', type: 'error');
        }
    }

    /**
     * Save machine type change
     */
    public function saveMachineType()
    {
        // Check permission
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to change machine type!', type: 'error');
            return;
        }

        $this->validate([
            'machine_type' => 'required|in:fuji,panasonic,both',
        ]);

        try {
            $line = MasterLine::findOrFail($this->line_id);
            $oldType = $line->machine_type;
            $line->update([
                'machine_type' => $this->machine_type,
            ]);

            $this->dispatch('close-change-machine-modal');
            $this->dispatch('notify', 
                message: "Machine type changed from '{$oldType}' to '{$this->machine_type}' successfully!", 
                type: 'success'
            );
            
            $this->resetForm();
            
        } catch (\Exception $e) {
            Log::error('Error changing machine type: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to change machine type!', type: 'error');
        }
    }

    /**
     * Open quick status update modal
     */
    public function quickStatusUpdate($id)
    {
        // Check permission
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to update status!', type: 'error');
            return;
        }

        try {
            $line = MasterLine::findOrFail($id);
            $this->line_id = $line->id;
            $this->status = $line->status;
            $this->trouble_desc = $line->trouble_desc;
            $this->modalTitle = 'Quick Status Update';
            $this->resetValidation();
            
            $this->dispatch('open-quick-status-modal');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Line not found!', type: 'error');
        }
    }

    /**
     * Save quick status update
     */
    public function saveQuickStatus()
    {
        // Check permission
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to update status!', type: 'error');
            return;
        }

        $this->validate([
            'status' => 'required|in:Running,Maintenance,No Schedule,Trouble',
            'trouble_desc' => 'nullable|string',
        ]);

        try {
            $line = MasterLine::findOrFail($this->line_id);
            $oldStatus = $line->status;
            
            $line->update([
                'status' => $this->status,
                'trouble_desc' => $this->status === 'Trouble' ? $this->trouble_desc : null,
            ]);

            $this->dispatch('close-quick-status-modal');
            
            $message = "Status changed from '{$oldStatus}' to '{$this->status}' successfully!";
            if ($this->status === 'Trouble' && $this->trouble_desc) {
                $message .= " Trouble description added.";
            }
            
            $this->dispatch('notify', message: $message, type: 'success');
            
            $this->resetForm();
            
        } catch (\Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to update status!', type: 'error');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'line_id', 'location_id', 'line_number', 'status', 
            'nik', 'trouble_desc', 'machine_type'
        ]);
        $this->resetValidation();
        $this->modalTitle = 'Add New Line';
        $this->status = 'Running';
        $this->machine_type = 'fuji';
    }

    public function edit($id)
    {
        // Check permission untuk edit
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to edit line!', type: 'error');
            return;
        }

        try {
            $line = MasterLine::findOrFail($id);
            $this->line_id = $line->id;
            $this->location_id = $line->location_id;
            $this->line_number = $line->line_number;
            $this->status = $line->status;
            $this->nik = $line->nik;
            $this->trouble_desc = $line->trouble_desc;
            $this->machine_type = $line->machine_type;
            $this->modalTitle = 'Edit Line';
            $this->resetValidation();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Line not found!', type: 'error');
        }
    }

    public function save()
    {
        // Check permission untuk create atau edit
        if ($this->line_id) {
            if (!auth()->user()->can('edit master line')) {
                $this->dispatch('notify', message: 'You do not have permission to update line!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create master line')) {
                $this->dispatch('notify', message: 'You do not have permission to create line!', type: 'error');
                return;
            }
        }
    
        // Validasi tanpa unique untuk line_number
        $this->validate();
    
        try {
            if ($this->line_id) {
                // Update existing line
                $line = MasterLine::findOrFail($this->line_id);
                $line->update([
                    'location_id' => $this->location_id,
                    'line_number' => $this->line_number,
                    'status' => $this->status,
                    'nik' => $this->nik,
                    'trouble_desc' => $this->trouble_desc,
                    'machine_type' => $this->machine_type,
                ]);
                $message = 'Line updated successfully!';
            } else {
                // Create new line
                MasterLine::create([
                    'location_id' => $this->location_id,
                    'line_number' => $this->line_number,
                    'status' => $this->status,
                    'nik' => $this->nik,
                    'trouble_desc' => $this->trouble_desc,
                    'machine_type' => $this->machine_type,
                ]);
                $message = 'Line created successfully!';
            }
    
            $this->resetForm();
            $this->dispatch('close-modal', 'line-form-modal');
            $this->dispatch('notify', message: $message, type: 'success');
            
        } catch (\Exception $e) {
            Log::error('Error saving line: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to save line!', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master line')) {
            $this->dispatch('notify', message: 'You do not have permission to delete line!', type: 'error');
            return;
        }

        try {
            $this->lineToDelete = MasterLine::withCount(['machines'])->findOrFail($id);
            $this->dispatch('open-modal', 'delete-line-modal');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Line not found!', type: 'error');
        }
    }

    public function delete()
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master line')) {
            $this->dispatch('notify', message: 'You do not have permission to delete line!', type: 'error');
            return;
        }

        try {
            $line = MasterLine::findOrFail($this->lineToDelete->id);
            
            // Check if line has related machines
            if ($line->machines()->count() > 0) {
                $this->dispatch('notify', 
                    message: 'Cannot delete line because it has ' . $line->machines()->count() . ' machine(s) associated!', 
                    type: 'warning'
                );
                $this->dispatch('close-modal', 'delete-line-modal');
                return;
            }
            
            $lineNumber = $line->line_number;
            $line->delete();
            
            $this->dispatch('close-modal', 'delete-line-modal');
            $this->dispatch('notify', message: "Line '{$lineNumber}' deleted successfully!", type: 'success');
            $this->lineToDelete = null;
            
        } catch (\Exception $e) {
            Log::error('Error deleting line: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to delete line!', type: 'error');
        }
    }

    public function getEmployeesProperty()
    {
        return Employee::orderBy('name')->get();
    }

    public function getLocationsProperty()
    {
        return MasterLocation::with('area')->orderBy('location_name')->get();
    }

    public function render()
    {
        // Check permission
        if (!auth()->user()->can('view master line')) {
            abort(403, 'You do not have permission to view master line.');
        }

        $locations = $this->locations;
        $employees = $this->employees;

        $lines = MasterLine::with([
                'location', 
                'location.area', 
                'employee', 
                'creator', 
                'updater', 
                'machines',
                'dailyFujiStandardCheck' // TAMBAHKAN INI
            ])
            ->when($this->search, function ($query) {
                $query->where('line_number', 'like', '%' . $this->search . '%')
                    ->orWhere('trouble_desc', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedLocation, function ($query) {
                $query->where('location_id', $this->selectedLocation);
            })
            ->when($this->selectedMachineType, function ($query) {
                $query->where('machine_type', $this->selectedMachineType);
            })
            ->when($this->selectedStatus, function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.mtc.master.master-line-management', [
            'lines' => $lines,
            'locations' => $locations,
            'employees' => $employees,
        ]);
    }
}